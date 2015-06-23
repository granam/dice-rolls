<?php
namespace Drd\DiceRoll;

use Granam\Integer\IntegerObject;
use Granam\Strict\Object\StrictObject;

class DiceRoll extends StrictObject
{
    /**
     * @var DiceInterface
     */
    private $dice;
    /**
     * @var IntegerObject
     */
    private $rolledNumber;
    /**
     * @var DiceRollEvaluatorInterface
     */
    private $diceRollEvaluator;
    /**
     * @var IntegerObject
     */
    private $rollSequence;

    /**
     * @param DiceInterface $dice
     * @param IntegerObject $rolledNumber
     * @param DiceRollEvaluatorInterface $diceRollEvaluator
     * @param IntegerObject $rollSequence
     */
    public function __construct(DiceInterface $dice, IntegerObject $rolledNumber, DiceRollEvaluatorInterface $diceRollEvaluator, IntegerObject $rollSequence)
    {
        $this->dice = $dice;
        $this->rolledNumber = $rolledNumber;
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
     * @return IntegerObject
     */
    public function getRolledNumber()
    {
        return $this->rolledNumber;
    }

    /**
     * @return IntegerObject
     */
    public function getEvaluatedValue()
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
     * @return IntegerObject
     */
    public function getRollSequence()
    {
        return $this->rollSequence;
    }

}
