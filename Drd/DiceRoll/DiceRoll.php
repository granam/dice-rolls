<?php
namespace Drd\DiceRoll;

use Granam\Integer\IntegerInterface;
use Granam\Strict\Object\StrictObject;

class DiceRoll extends StrictObject
{
    /**
     * @var DiceInterface
     */
    private $dice;
    /**
     * @var IntegerInterface
     */
    private $rolledNumber;
    /**
     * @var DiceRollEvaluatorInterface
     */
    private $diceRollEvaluator;
    /**
     * @var IntegerInterface
     */
    private $rollSequence;

    /**
     * @param DiceInterface $dice
     * @param IntegerInterface $rolledNumber
     * @param DiceRollEvaluatorInterface $diceRollEvaluator
     * @param IntegerInterface $rollSequence
     */
    public function __construct(DiceInterface $dice, IntegerInterface $rolledNumber, DiceRollEvaluatorInterface $diceRollEvaluator, IntegerInterface $rollSequence)
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
     * @return IntegerInterface
     */
    public function getRolledNumber()
    {
        return $this->rolledNumber;
    }

    /**
     * @return IntegerInterface
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
     * @return IntegerInterface
     */
    public function getRollSequence()
    {
        return $this->rollSequence;
    }

}
