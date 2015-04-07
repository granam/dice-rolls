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
     * @var StrictInteger
     */
    private $rollNumber;
    /**
     * @var StrictInteger
     */
    private $repeatOnValue;
    /**
     * @var array|DiceRoll[]
     */
    private $lastDiceRolls = [];

    /**
     * @param Dice $dice
     * @param StrictInteger $rollNumber (default 1)
     * @param StrictInteger $repeatOnValue (default 0; never)
     */
    public function __construct(Dice $dice, StrictInteger $rollNumber = null, StrictInteger $repeatOnValue = null)
    {
        $rollNumber = $rollNumber ?: new StrictInteger(1);
        $this->checkRollNumber($rollNumber);
        $repeatOnValue = $repeatOnValue ?: new StrictInteger(0);
        $this->checkInfiniteRepeat($dice, $repeatOnValue);
        $this->dice = $dice;
        $this->rollNumber = $rollNumber;
        $this->repeatOnValue = $repeatOnValue;
    }

    private function checkRollNumber(StrictInteger $rollNumber)
    {
        if ($rollNumber->getValue() <= 0) {
            throw new \LogicException(
                'Roll number has to be greater than zero. Zero rolls have no sense.'
            );
        }
    }

    /**
     * @param Dice $dice
     * @param $repeatOnValue
     */
    private function checkInfiniteRepeat(Dice $dice, StrictInteger $repeatOnValue)
    {
        if ($dice->getMinimum()->getValue() === $repeatOnValue->getValue()
            && $dice->getMaximum()->getValue() === $repeatOnValue->getValue()
        ) {
            throw new \LogicException(
                'Rolls would be repeated indefinitely. The value to repeat on '
                . var_export($repeatOnValue->getValue(), true) . ' is the only value the given dice can roll.'
            );
        }
    }

    /**
     * @return int
     */
    public function roll()
    {
        $this->lastDiceRolls = [];
        for ($rollNumberValue = 1; $rollNumberValue <= $this->rollNumber->getValue(); $rollNumberValue++) {
            $rollNumber = new StrictInteger($rollNumberValue);
            $this->lastDiceRolls[] = $diceRoll = $this->rollDice($this->dice, $rollNumber, false /* not bonus roll */);
            while ($diceRoll->getRolledValue()->getValue() === $this->repeatOnValue->getValue()) {
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
     * @return StrictInteger
     */
    public function getRollNumber()
    {
        return $this->rollNumber;
    }

    /**
     * @return StrictInteger
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