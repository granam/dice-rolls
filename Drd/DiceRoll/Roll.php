<?php
namespace Drd\DiceRoll;

use Granam\Strict\Integer\StrictInteger;
use Granam\Strict\Object\StrictObject;

class Roll extends StrictObject
{
    /**
     * @var Dice
     */
    private $dice;
    /**
     * @var int
     */
    private $rollNumber;
    /**
     * @var int
     */
    private $repeatOnValue;
    /**
     * @var array|DiceRoll[]
     */
    private $lastDiceRolls;

    /**
     * @param Dice $dice
     * @param int $rollNumber
     * @param int $repeatOnValue
     */
    public function __construct($dice, $rollNumber = 1, $repeatOnValue = 0)
    {
        $rollNumber = intval($rollNumber);
        $this->checkRollNumber($rollNumber);
        $repeatOnValue = intval($repeatOnValue);
        $this->checkInfiniteRepeat($dice, $repeatOnValue);
        $this->dice = $dice;
        $this->rollNumber = $rollNumber;
        $this->repeatOnValue = $repeatOnValue;
        $this->lastDiceRolls = [];
    }

    private function checkRollNumber($rollNumber)
    {
        if ($rollNumber <= 0) {
            throw new \LogicException(
                'Roll number has to be greater than zero. Zero rolls have no sense.'
            );
        }
    }

    /**
     * @param Dice $dice
     * @param $repeatOnValue
     */
    private function checkInfiniteRepeat($dice, $repeatOnValue)
    {
        if ($dice->getMinimum()->getValue() === $repeatOnValue
            && $dice->getMaximum()->getValue() === $repeatOnValue
        ) {
            throw new \LogicException(
                'Rolls would be repeated indefinitely. The value to repeat on '
                . var_export($repeatOnValue, true) . ' is the only value the given dice can roll.'
            );
        }
    }

    /**
     * @return int
     */
    public function roll()
    {
        for ($rollNumberValue = 1; $rollNumberValue <= $this->rollNumber; $rollNumberValue++) {
            $rollNumber = new StrictInteger($rollNumberValue);
            $this->lastDiceRolls[] = $diceRoll = $this->rollDice($this->dice, $rollNumber, false /* not bonus roll */);
            while ($diceRoll->getRolledValue()->getValue() === $this->repeatOnValue) {
                $this->lastDiceRolls[] = $diceRoll = $this->rollDice($this->dice, $rollNumber, true /* bonus roll */);
            }
        }

        return $this->getLastRollSummary();
    }

    private function rollDice(Dice $dice, $rollNumber, $isBonusRoll)
    {
        return new DiceRoll(
            $dice,
            new StrictInteger(mt_rand($dice->getMinimum()->getValue(), $dice->getMaximum()->getValue())),
            $rollNumber,
            $isBonusRoll
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
     * @return int
     */
    public function getRollNumber()
    {
        return $this->rollNumber;
    }

    /**
     * @return int
     */
    public function getRepeatOnValue()
    {
        return $this->repeatOnValue;
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
    public function getLastRollNumbers()
    {
        return array_map(
            function (DiceRoll $diceRoll) {
                return $diceRoll->getRolledValue();
            },
            $this->lastDiceRolls
        );
    }

    /**
     * @return int
     */
    public function getLastRollSummary()
    {
        return array_sum(
            array_map(
                function (StrictInteger $rollNumber) {
                    return $rollNumber->getValue();
                },
                $this->getLastRollNumbers()
            )
        );
    }
}
