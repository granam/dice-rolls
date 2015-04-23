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
     * @var DiceRollEvaluatorInterface
     */
    private $diceRollEvaluator;
    /**
     * @var StrictInteger
     */
    private $rollSequence;

    /**
     * @param DiceInterface $dice
     * @param StrictInteger $rolledValue
     * @param DiceRollEvaluatorInterface $diceRollEvaluator
     * @param StrictInteger $rollSequence
     */
    public function __construct(DiceInterface $dice, StrictInteger $rolledValue, DiceRollEvaluatorInterface $diceRollEvaluator, StrictInteger $rollSequence)
    {
        $this->dice = $dice;
        $this->rolledValue = $rolledValue;
        $this->diceRollEvaluator = $diceRollEvaluator;
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
     * @return int
     */
    public function getValue()
    {
        return $this->diceRollEvaluator->evaluateDiceRoll($this);
    }

    /**
     * @return DiceRollEvaluatorInterface
     */
    public function getDiceRollEvaluator()
    {
        return $this->diceRollEvaluator;
    }

    /**
     * @return StrictInteger
     */
    public function getRollSequence()
    {
        return $this->rollSequence;
    }

}
