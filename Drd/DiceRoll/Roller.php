<?php
namespace Drd\DiceRoll;

use Granam\Integer\IntegerInterface;
use Granam\Integer\IntegerObject;
use Granam\Integer\Tools\ToInteger;
use Granam\Strict\Object\StrictObject;
use Granam\Tools\ValueDescriber;

class Roller extends StrictObject
{

    /**
     * @var Dice
     */
    private $dice;
    /**
     * @var IntegerInterface
     */
    private $numberOfStandardRolls;
    /**
     * @var DiceRollEvaluator
     */
    private $diceRollEvaluator;
    /**
     * @var RollOn
     */
    private $bonusRollOn;
    /**
     * @var RollOn
     */
    private $malusRollOn;

    /**
     * @param Dice $dice
     * @param IntegerInterface $numberOfStandardRolls
     * @param DiceRollEvaluator $diceRollEvaluator
     * @param RollOn $bonusRollOn
     * @param RollOn $malusRollOn malus roll itself is responsible for negative or positive numbers
     */
    public function __construct(
        Dice $dice,
        IntegerInterface $numberOfStandardRolls,
        DiceRollEvaluator $diceRollEvaluator,
        RollOn $bonusRollOn,
        RollOn $malusRollOn
    )
    {
        $this->checkDice($dice);
        $this->checkNumberOfStandardRolls($numberOfStandardRolls);
        $this->checkBonusAndMalusConflicts($dice, $bonusRollOn, $malusRollOn);
        $this->dice = $dice;
        $this->numberOfStandardRolls = $numberOfStandardRolls;
        $this->diceRollEvaluator = $diceRollEvaluator;
        $this->bonusRollOn = $bonusRollOn;
        $this->malusRollOn = $malusRollOn;
    }

    private function checkDice(Dice $dice)
    {
        if ($dice->getMinimum()->getValue() > $dice->getMaximum()->getValue()) {
            throw new Exceptions\InvalidDiceRange(
                'Dice minimum value has to be same or lesser than maximum value.'
                . " Got minimum {$dice->getMinimum()->getValue()} and maximum {$dice->getMaximum()->getValue()}."
            );
        }
    }

    private function checkNumberOfStandardRolls(IntegerInterface $numberOfStandardRolls)
    {
        if ($numberOfStandardRolls->getValue() <= 0) {
            throw new Exceptions\InvalidNumberOfRolls(
                'Roll number has to be at least one, less rolls have no sense.'
                . " Got {$numberOfStandardRolls->getValue()}."
            );
        }
    }

    /**
     * @param Dice $dice
     * @param RollOn $bonusRollOn
     * @param RollOn $malusRollOn
     */
    private function checkBonusAndMalusConflicts(Dice $dice, RollOn $bonusRollOn, RollOn $malusRollOn)
    {
        $bonusRollOnValues = $this->findRollOnValues($dice->getMinimum()->getValue(), $dice->getMaximum()->getValue(), $bonusRollOn);
        $malusRollOnValues = $this->findRollOnValues($dice->getMinimum()->getValue(), $dice->getMaximum()->getValue(), $malusRollOn);
        $conflicts = array_intersect($bonusRollOnValues, $malusRollOnValues);
        if (count($conflicts) > 0) {
            throw new Exceptions\BonusAndMalusChanceConflict('Bonus and malus rolls would happen on same values: ' . implode(',', $conflicts));
        }
    }

    /**
     * @param int $minimumRollValue
     * @param int $maximumRollValue
     * @param RollOn $rollOn
     *
     * @return array|int[]
     */
    private function findRollOnValues($minimumRollValue, $maximumRollValue, RollOn $rollOn)
    {
        $rollOnValues = [];
        for ($rollValue = $minimumRollValue; $rollValue <= $maximumRollValue; $rollValue++) {
            if ($rollOn->shouldHappen($rollValue)) {
                $rollOnValues[] = $rollValue;
            }
        }

        return $rollOnValues;
    }

    /**
     * @param int $rollSequenceStart = 1
     * @return Roll
     */
    public function roll($rollSequenceStart = 1)
    {
        $standardDiceRolls = [];
        $rollSequenceStart = $this->validateSequenceStart($rollSequenceStart);
        $rollSequenceEnd = $this->numberOfStandardRolls->getValue() + $rollSequenceStart - 1;
        for ($rollSequenceValue = $rollSequenceStart;
            $rollSequenceValue <= $rollSequenceEnd; $rollSequenceValue++
        ) {
            $rollSequence = new IntegerObject($rollSequenceValue);
            $standardDiceRolls[] = $this->rollDice($rollSequence);
        }
        $standardRollsSum = $this->summarizeValues($this->extractRolledNumbers($standardDiceRolls));
        $nextSequenceStep = $rollSequenceEnd + 1;
        $bonusDiceRolls = $this->rollBonusDices($standardRollsSum, $nextSequenceStep);
        $malusDiceRolls = $this->rollMalusDices($standardRollsSum, $nextSequenceStep);

        return new Roll($standardDiceRolls, $bonusDiceRolls, $malusDiceRolls);
    }

    private function validateSequenceStart($start)
    {
        if (!is_numeric($start) || $start < 1) {
            throw new Exceptions\InvalidSequenceNumber(
                'Roll sequence start has to be at least 1, got ' . ValueDescriber::describe($start)
            );
        }
        try {
            return ToInteger::toInteger($start);
        } catch (\Granam\Integer\Tools\Exceptions\WrongParameterType $exception) {
            throw new Exceptions\InvalidSequenceNumber(
                'Roll sequence start has to be an integer. ' . $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }
    }

    /**
     * @param $standardRollsSum
     * @param int $rollSequenceStart
     * @return array|DiceRoll[]
     */
    private function rollBonusDices($standardRollsSum, $rollSequenceStart)
    {
        if (!$this->bonusRollOn->shouldHappen($standardRollsSum)) {
            return [];
        }

        return $this->bonusRollOn->rollDices($rollSequenceStart);
    }

    /**
     * @param $standardRollsSum
     * @param int $rollSequenceStart
     * @return array|DiceRoll[]
     */
    private function rollMalusDices($standardRollsSum, $rollSequenceStart)
    {
        if (!$this->malusRollOn->shouldHappen($standardRollsSum)) {
            return [];
        }

        return $this->malusRollOn->rollDices($rollSequenceStart);
    }

    /**
     * @param IntegerInterface $rollSequence
     *
     * @return DiceRoll
     */
    private function rollDice(IntegerInterface $rollSequence)
    {
        return new DiceRoll(
            $this->dice,
            new IntegerObject($this->rollNumber($this->dice)),
            $rollSequence,
            $this->diceRollEvaluator
        );
    }

    /**
     * @param Dice $dice
     *
     * @return int
     */
    private function rollNumber(Dice $dice)
    {
        return mt_rand($dice->getMinimum()->getValue(), $dice->getMaximum()->getValue());
    }

    /**
     * @param array|DiceRoll[] $diceRolls
     *
     * @return array|IntegerInterface[]
     */
    private function extractRolledNumbers(array $diceRolls)
    {
        return array_merge(
            array_map(
                function (DiceRoll $diceRoll) {
                    return $diceRoll->getRolledNumber();
                },
                $diceRolls
            )
        );
    }

    /**
     * @param array|IntegerInterface[] $values
     *
     * @return int
     */
    private function summarizeValues(array $values)
    {
        return array_sum(
            array_map(
                function (IntegerInterface $value) {
                    return $value->getValue();
                },
                $values
            )
        );
    }

    /**
     * @return Dice
     */
    public function getDice()
    {
        return $this->dice;
    }

    /**
     * @return IntegerInterface
     */
    public function getNumberOfStandardRolls()
    {
        return $this->numberOfStandardRolls;
    }

    /**
     * @return DiceRollEvaluator
     */
    public function getDiceRollEvaluator()
    {
        return $this->diceRollEvaluator;
    }

    /**
     * @return RollOn|null
     */
    public function getBonusRollOn()
    {
        return $this->bonusRollOn;
    }

    /**
     * @return RollOn|null
     */
    public function getMalusRollOn()
    {
        return $this->malusRollOn;
    }

}
