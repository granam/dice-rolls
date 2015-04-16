<?php
namespace Drd\DiceRoll;

use Granam\Strict\Integer\StrictInteger;
use Granam\Strict\Object\StrictObject;

class DiceRoll extends StrictObject
{
    /**
     * @var DiceInterface
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
     * @param DiceInterface $dice
     * @param StrictInteger $rolledValue
     * @param StrictInteger $rollSequence
     */
    public function __construct(DiceInterface $dice, StrictInteger $rolledValue, StrictInteger $rollSequence)
    {
        $this->dice = $dice;
        $this->rolledValue = $rolledValue;
        $this->rollSequence = $rollSequence;
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
