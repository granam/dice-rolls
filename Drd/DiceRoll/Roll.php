<?php
namespace Drd\DiceRoll;

use Granam\Strict\Integer\StrictInteger;
use Granam\Strict\Object\StrictObject;

class Roll extends StrictObject
{
    /**
     * @var array|Dice[]
     */
    private $dices;
    /**
     * @var int
     */
    private $rollCount;
    /**
     * @var int
     */
    private $repeatOnValue;
    /**
     * @var array|DiceRoll[]
     */
    private $lastRoll;

    /**
     * @param array|Dice[] $dices
     * @param int $rollCount
     * @param int $repeatOnValue
     */
    public function __construct(array $dices, $rollCount = 1, $repeatOnValue = 0)
    {
        $repeatOnValue = intval($repeatOnValue);
        $this->checkDices($dices);
        $this->checkInfiniteRepeat($dices, $repeatOnValue);
        $this->dices = $dices;
        $this->rollCount = intval($rollCount);
        $this->repeatOnValue = $repeatOnValue;
        $this->lastRoll = [];
    }

    private function checkDices(array $dices)
    {
        if (count($dices) === 0) {
            throw new \LogicException('No dice given.');
        }
    }

    /**
     * @param array|Dice[] $dices
     * @param $repeatOnValue
     */
    private function checkInfiniteRepeat(array $dices, $repeatOnValue)
    {
        foreach ($dices as $dice) {
            if ($dice->getMinimum()->getValue() === $dice->getMaximum()->getValue() && $dice->getMaximum()->getValue() === $repeatOnValue) {
                throw new \LogicException(
                    'Rolls would be repeated indefinitely. The value to repeat on '
                    . var_export($repeatOnValue, true) . ' is the only value the given dice can roll.'
                );
            }
        }
    }

    /**
     * @return $this
     */
    public function roll()
    {
        for ($rollNumberValue = 1; $rollNumberValue <= $this->rollCount; $rollNumberValue++) {
            $rollNumber = new StrictInteger($rollNumberValue);
            foreach ($this->dices as $dice) {
                $this->lastRoll[] = $diceRoll = $this->rollDice($dice, $rollNumber, false /* not bonus roll */);
                while ($diceRoll->getRolledValue()->getValue() === $this->repeatOnValue) {
                    $this->lastRoll[] = $diceRoll = $this->rollDice($dice, $rollNumber, true /* bonus roll */);
                }
            }
        }

        return $this;
    }

    private function rollDice(Dice $dice, $rollNumber, $isBonusRoll)
    {
        return new DiceRoll(
            $dice,
            new StrictInteger(mt_rand($dice->getMinimum(), $dice->getMaximum())),
            $rollNumber,
            $isBonusRoll
        );
    }

    /**
     * @return array|Dice[]
     */
    public function getDices()
    {
        return $this->dices;
    }

    /**
     * @return int
     */
    public function getRollCount()
    {
        return $this->rollCount;
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
    public function getLastRoll()
    {
        return $this->lastRoll;
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
            $this->lastRoll
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
