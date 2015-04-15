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
     * @param Dice $dice
     * @param StrictInteger $rolledValue
     * @param StrictInteger $rollSequence
     */
    public function __construct(Dice $dice, StrictInteger $rolledValue, StrictInteger $rollSequence)
    {
        $this->dice = $dice;
        $this->rolledValue = $rolledValue;
        $this->rollSequence = $rollSequence;
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
    public function getRolledValue()
    {
        return $this->rolledValue;
    }

    /**
     * @return StrictInteger
     */
    public function getRollSequence()
    {
        return $this->rollSequence;
    }

}
