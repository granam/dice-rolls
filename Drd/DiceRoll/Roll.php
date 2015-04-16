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
     * @param RollOnInterface $bonusRollOn
     * @param RollOnInterface $malusRollOn
     */
    public function __construct(
        DiceInterface $dice,
        StrictInteger $numberOfRolls,
        RollOnInterface $bonusRollOn,
        RollOnInterface $malusRollOn
    )
    {
        $this->checkDice($dice);
        $this->checkNumberOfRolls($numberOfRolls);
        $this->checkBonusAndMalusConflicts($dice, $bonusRollOn, $malusRollOn);
        $this->checkInfiniteRepeat($dice, $bonusRollOn, $malusRollOn);
        $this->dice = $dice;
        $this->numberOfRolls = $numberOfRolls;
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
            if ($rollOn->shouldRepeatRoll($rollValue)) {
                $rollOnValues[] = $rollValue;
            }
        }

        return $rollOnValues;
    }

    private function checkInfiniteRepeat(DiceInterface $dice, RollOnInterface $bonusRollOn, RollOnInterface $malusRollOn)
    {
        $this->checkBonusInfiniteRepeat($dice, $bonusRollOn);
        $this->checkMalusInfiniteRepeat($dice, $malusRollOn);
    }

    private function checkBonusInfiniteRepeat(DiceInterface $dice, RollOnInterface $bonusRollOn)
    {
        if ($this->isInfiniteRepeat($dice, $bonusRollOn)) {
            throw new \LogicException(
                "Bonus rolls would be repeated indefinitely. Every of the value in range "
                . "{$dice->getMinimum()->getValue()} - {$dice->getMaximum()->getValue()} triggers bonus roll."
            );
        }
    }

    private function checkMalusInfiniteRepeat(DiceInterface $dice, RollOnInterface $malusRollOn)
    {
        if ($this->isInfiniteRepeat($dice, $malusRollOn)) {
            throw new \LogicException(
                "Malus rolls would be repeated indefinitely. Every of the value in range "
                . "{$dice->getMinimum()->getValue()} - {$dice->getMaximum()->getValue()} triggers malus roll."
            );
        }
    }

    private function isInfiniteRepeat(DiceInterface $dice, RollOnInterface $rollOn)
    {
        $infinite = true;
        for ($value = $dice->getMinimum()->getValue(); $infinite && $value <= $dice->getMaximum()->getValue(); $value++) {
            $infinite &= $rollOn->shouldRepeatRoll($value);
        }

        return $infinite;
    }

    /**
     * @return int
     */
    public function roll()
    {
        $this->lastDiceRolls = [];
        $this->lastStandardDiceRolls = [];
        for ($rollSequenceValue = 1; $rollSequenceValue <= $this->numberOfRolls->getValue(); $rollSequenceValue++) {
            $rollSequence = new StrictInteger($rollSequenceValue);
            $this->lastDiceRolls[] = $this->lastStandardDiceRolls[] = $diceRoll = $this->rollDice($this->dice, $rollSequence);
        }
        $standardRollSummary = $this->getLastStandardRollSummary();
        if ($this->bonusRollOn->shouldRepeatRoll($standardRollSummary)) {
            $this->bonusRollOn->getRoll()->roll();
            $this->lastDiceRolls = array_merge($this->lastDiceRolls, $this->bonusRollOn->getRoll()->getLastDiceRolls());
        } else if ($this->malusRollOn->shouldRepeatRoll($standardRollSummary)) {
            $this->malusRollOn->getRoll()->roll();
            $this->lastDiceRolls = array_merge($this->lastDiceRolls, $this->malusRollOn->getRoll()->getLastDiceRolls());
        }

        return $this->getLastRollSummary();
    }

    /**
     * @param DiceInterface $dice
     * @param StrictInteger $rollSequence
     *
     * @return DiceRoll
     */
    private function rollDice(DiceInterface $dice, $rollSequence)
    {
        return new DiceRoll(
            $dice,
            new StrictInteger(mt_rand($dice->getMinimum()->getValue(), $dice->getMaximum()->getValue())),
            $rollSequence
        );
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
        return array_merge(
            array_map(
                function (DiceRoll $diceRoll) {
                    return $diceRoll->getRolledValue();
                },
                $this->lastDiceRolls
            )
        );
    }

    /**
     * @return int
     */
    public function getLastRollSummary()
    {
        return $this->getLastStandardRollSummary() + $this->bonusRollOn->getLastRollSummary() + $this->malusRollOn->getLastRollSummary();
    }

    /**
     * @return int
     */
    private function getLastStandardRollSummary()
    {
        return array_sum(
            array_map(
                function (DiceRoll $diceRoll) {
                    return $diceRoll->getRolledValue()->getValue();
                },
                $this->lastStandardDiceRolls
            )
        );
    }

    /**
     * @return array|DiceRoll[]
     */
    public function getLastStandardDiceRolls()
    {
        return $this->lastStandardDiceRolls;
    }
}
