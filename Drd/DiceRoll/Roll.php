<?php
namespace Drd\DiceRoll;

use Granam\Strict\Integer\StrictInteger;
use Granam\Strict\Object\StrictObject;

class Roll extends StrictObject implements RollInterface
{

    /**
     * @var DiceInterface
     */
    private $dice;
    /**
     * @var StrictInteger
     */
    private $numberOfRolls;
    /**
     * @var DiceRollEvaluatorInterface
     */
    private $diceRollBuilder;
    /**
     * @var RollOnInterface
     */
    private $bonusRollOn;
    /**
     * @var RollOnInterface
     */
    private $malusRollOn;
    /**
     * Standard dice rolls, without bonus and malus rolls
     *
     * @var array|DiceRoll[]
     */
    private $lastStandardDiceRolls = [];
    /**
     * All dice rolls, including bonus and malus ones
     *
     * @var array|DiceRoll[]
     */
    private $lastDiceRolls = [];

    /**
     * @param DiceInterface $dice
     * @param StrictInteger $numberOfRolls
     * @param DiceRollBuilderInterface $diceRollBuilder ,
     * @param RollOnInterface $bonusRollOn
     * @param RollOnInterface $malusRollOn malus roll itself is responsible for negative or positive numbers
     */
    public function __construct(
        DiceInterface $dice,
        StrictInteger $numberOfRolls,
        DiceRollBuilderInterface $diceRollBuilder,
        RollOnInterface $bonusRollOn,
        RollOnInterface $malusRollOn
    )
    {
        $this->checkDice($dice);
        $this->checkNumberOfRolls($numberOfRolls);
        $this->checkBonusAndMalusConflicts($dice, $bonusRollOn, $malusRollOn);
        $this->dice = $dice;
        $this->numberOfRolls = $numberOfRolls;
        $this->diceRollBuilder = $diceRollBuilder;
        $this->bonusRollOn = $bonusRollOn;
        $this->malusRollOn = $malusRollOn;
    }

    private function checkNumberOfRolls(StrictInteger $rollNumber)
    {
        if ($rollNumber->getValue() <= 0) {
            throw new \LogicException(
                'Roll number has to be greater than zero. Zero rolls have no sense.'
            );
        }
    }

    private function checkDice(DiceInterface $dice)
    {
        if ($dice->getMinimum()->getValue() > $dice->getMaximum()->getValue()) {
            throw new \LogicException(
                "DiceInterface minimum value has to be at least same or lesser then maximum value."
                . " Got minimum {$dice->getMinimum()->getValue()} and maximum {$dice->getMaximum()->getValue()}"
            );
        }
    }

    /**
     * @param DiceInterface $dice
     * @param RollOnInterface $bonusRollOn
     * @param RollOnInterface $malusRollOn
     */
    private function checkBonusAndMalusConflicts(DiceInterface $dice, RollOnInterface $bonusRollOn, RollOnInterface $malusRollOn)
    {
        $bonusRollOnValues = $this->getRollOnValues($dice->getMinimum()->getValue(), $dice->getMaximum()->getValue(), $bonusRollOn);
        $malusRollOnValues = $this->getRollOnValues($dice->getMinimum()->getValue(), $dice->getMaximum()->getValue(), $malusRollOn);
        $conflicts = array_intersect($bonusRollOnValues, $malusRollOnValues);
        if (count($conflicts) > 0) {
            throw new \LogicException('Bonus and malus rolls would happen on same values: ' . implode(',', $conflicts));
        }
    }

    /**
     * @param int $minimumRollValue
     * @param int $maximumRollValue
     * @param RollOnInterface $rollOn
     *
     * @return array|int
     */
    private function getRollOnValues($minimumRollValue, $maximumRollValue, RollOnInterface $rollOn)
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
     * @return int
     */
    public function roll()
    {
        $this->resetLastDiceRolls();
        $this->processStandardRolls();
        $standardRollNumbersSum = $this->getLastStandardRollNumbersSum();
        if ($this->bonusRollOn->shouldHappen($standardRollNumbersSum)) {
            $this->processBonusRolls();
        } else if ($this->malusRollOn->shouldHappen($standardRollNumbersSum)) {
            $this->processMalusRolls();
        }

        return $this->getLastRollSummary();
    }

    private function resetLastDiceRolls()
    {
        $this->lastDiceRolls = []; // all the dice rolls, including those from bonus and malus rolls
        $this->lastStandardDiceRolls = []; // dice rolls without bonus and malus rolls
    }

    private function processStandardRolls()
    {
        for ($rollSequenceValue = 1; $rollSequenceValue <= $this->numberOfRolls->getValue(); $rollSequenceValue++) {
            $rollSequence = new StrictInteger($rollSequenceValue);
            $standardDiceRoll = $this->rollDice($rollSequence);
            $this->addLastStandardDiceRoll($standardDiceRoll);
        }
    }

    /**
     * @param StrictInteger $rollSequence
     *
     * @return DiceRoll
     */
    private function rollDice(StrictInteger $rollSequence)
    {
        return $this->getDiceRollBuilder()->create(
            $this->dice,
            new StrictInteger($this->rollNumber($this->dice)),
            $rollSequence
        );
    }

    /**
     * @param DiceInterface $dice
     *
     * @return int
     */
    private function rollNumber(DiceInterface $dice)
    {
        return mt_rand($dice->getMinimum()->getValue(), $dice->getMaximum()->getValue());
    }

    private function addLastStandardDiceRoll(DiceRoll $diceRoll)
    {
        $this->lastDiceRolls[] = $this->lastStandardDiceRolls[] = $diceRoll;
    }

    private function processBonusRolls()
    {
        $this->bonusRollOn->getRoll()->roll();
        $this->addLastDiceRolls($this->bonusRollOn->getRoll()->getLastDiceRolls());
    }

    /**
     * @param array|DiceRoll[] $diceRolls
     */
    private function addLastDiceRolls(array $diceRolls)
    {
        $this->lastDiceRolls = array_merge($this->lastDiceRolls, $diceRolls);
    }

    private function processMalusRolls()
    {
        $this->malusRollOn->getRoll()->roll();
        $this->addLastDiceRolls($this->malusRollOn->getRoll()->getLastDiceRolls());
    }

    /**
     * @return DiceInterface
     */
    public function getDice()
    {
        return $this->dice;
    }

    /**
     * @return StrictInteger
     */
    public function getNumberOfRolls()
    {
        return $this->numberOfRolls;
    }

    /**
     * @return DiceRollBuilderInterface
     */
    public function getDiceRollBuilder()
    {
        return $this->diceRollBuilder;
    }

    /**
     * @return RollOnInterface
     */
    public function getBonusRollOn()
    {
        return $this->bonusRollOn;
    }

    /**
     * @return RollOnInterface
     */
    public function getMalusRollOn()
    {
        return $this->malusRollOn;
    }

    /**
     * @return array|DiceRoll[]
     */
    public function getLastDiceRolls()
    {
        return $this->lastDiceRolls;
    }

    /**
     * @return array|StrictInteger[]
     */
    public function getLastRolledNumbers()
    {
        return $this->extractRolledNumbers($this->lastDiceRolls);
    }

    /**
     * @param array|DiceRoll[] $diceRolls
     *
     * @return array|StrictInteger[]
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
     * @return int
     */
    public function getLastRollSummary()
    {
        return $this->summarizeDiceRolls($this->lastDiceRolls);
    }

    /**
     * @param array|DiceRoll[] $diceRolls
     *
     * @return int
     */
    private function summarizeDiceRolls(array $diceRolls)
    {
        return $this->summarizeValues($this->extractRolledValues($diceRolls));
    }

    /**
     * @param array|DiceRoll[] $diceRolls
     *
     * @return array|StrictInteger[]
     */
    private function extractRolledValues(array $diceRolls)
    {
        return array_merge(
            array_map(
                function (DiceRoll $diceRoll) {
                    return $diceRoll->getEvaluatedValue();
                },
                $diceRolls
            )
        );
    }

    /**
     * @param array|StrictInteger[] $values
     *
     * @return int
     */
    private function summarizeValues(array $values)
    {
        return array_sum(
            array_map(
                function (StrictInteger $value) {
                    return $value->getValue();
                },
                $values
            )
        );
    }

    /**
     * @return int
     */
    private function getLastStandardRollNumbersSum()
    {
        return $this->summarizeValues($this->extractRolledNumbers($this->lastStandardDiceRolls));
    }

    /**
     * @return array|DiceRoll[]
     */
    public function getLastStandardDiceRolls()
    {
        return $this->lastStandardDiceRolls;
    }
}
