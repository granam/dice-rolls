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
    private $rollNumber;
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
     * @param int $rollNumber
     * @param int $repeatOnValue
     */
    public function __construct(array $dices, $rollNumber = 1, $repeatOnValue = 0)
    {
        $this->checkDices($dices);
        $rollNumber = intval($rollNumber);
        $this->checkRollNumber($rollNumber);
        $repeatOnValue = intval($repeatOnValue);
        $this->checkInfiniteRepeat($dices, $repeatOnValue);
        $this->dices = $dices;
        $this->rollNumber = $rollNumber;
        $this->repeatOnValue = $repeatOnValue;
        $this->lastRoll = [];
    }

    private function checkDices(array $dices)
    {
        if (count($dices) === 0) {
            throw new \LogicException('No dice given.');
        }
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
     * @param array|Dice[] $dices
     * @param $repeatOnValue
     */
    private function checkInfiniteRepeat(array $dices, $repeatOnValue)
    {
        foreach ($dices as $dice) {
            if ($dice->getMinimum()->getValue() === $repeatOnValue
                && $dice->getMaximum()->getValue() === $repeatOnValue
            ) {
                throw new \LogicException(
                    'Rolls would be repeated indefinitely. The value to repeat on '
                    . var_export($repeatOnValue, true) . ' is the only value the given dice can roll.'
                );
            }
        }
    }

    /**
     * @return array|DiceRoll[]
     */
    public function roll()
    {
        for ($rollNumberValue = 1; $rollNumberValue <= $this->rollNumber; $rollNumberValue++) {
            $rollNumber = new StrictInteger($rollNumberValue);
            foreach ($this->dices as $dice) {
                $this->lastRoll[] = $diceRoll = $this->rollDice($dice, $rollNumber, false /* not bonus roll */);
                while ($diceRoll->getRolledValue()->getValue() === $this->repeatOnValue) {
                    $this->lastRoll[] = $diceRoll = $this->rollDice($dice, $rollNumber, true /* bonus roll */);
                }
            }
        }

        return $this->lastRoll;
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
     * @return array|Dice[]
     */
    public function getDices()
    {
        return $this->dices;
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
