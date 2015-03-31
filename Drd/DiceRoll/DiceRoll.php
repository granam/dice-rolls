<?php
namespace Drd\DiceRoll;

use Granam\Strict\Integer\StrictInteger;
use Granam\Strict\Object\StrictObject;

class DiceRoll extends StrictObject
{
    /**
     * @var Dice
     */
    private $dice;
    /**
     * @var StrictInteger
     */
    private $rolledValue;
    /**
     * @var StrictInteger
     */
    private $rollSequence;
    /**
     * @var bool
     */
    private $isBonusRoll;

    /**
     * @param Dice $dice
     * @param StrictInteger $rolledValue
     * @param StrictInteger $rollSequence
     * @param bool $isBonusRoll
     */
    public function __construct(Dice $dice, StrictInteger $rolledValue, StrictInteger $rollSequence, $isBonusRoll)
    {
        $this->dice = $dice;
        $this->rolledValue = $rolledValue;
        $this->rollSequence = $rollSequence;
        $this->isBonusRoll = $isBonusRoll;
    }

    /**
     * @return Dice
     */
    public function getDice()
    {
        return $this->dice;
    }

    /**
     * @return boolean
     */
    public function isIsBonusRoll()
    {
        return $this->isBonusRoll;
    }

    /**
     * @return StrictInteger
     */
    public function getRollSequence()
    {
        return $this->rollSequence;
    }

    /**
     * @return StrictInteger
     */
    public function getRolledValue()
    {
        return $this->rolledValue;
    }
}
