<?php
namespace Drd\DiceRoll;

use Granam\Integer\IntegerInterface;
use Granam\Strict\Object\StrictObject;

class DiceRoll extends StrictObject implements IntegerInterface
{
    /**
     * @var Dice
     */
    private $dice;
    /**
     * @var IntegerInterface
     */
    private $rolledNumber;
    /**
     * @var IntegerInterface
     */
    private $rollSequence;
    /**
     * @var DiceRollEvaluator
     */
    private $diceRollEvaluator;

    /**
     * @param Dice $dice
     * @param IntegerInterface $rolledNumber
     * @param IntegerInterface $rollSequence
     * @param DiceRollEvaluator $diceRollEvaluator
     */
    public function __construct(
        Dice $dice,
        IntegerInterface $rolledNumber,
        IntegerInterface $rollSequence,
        DiceRollEvaluator $diceRollEvaluator
    )
    {
        $this->dice = $dice;
        $this->rolledNumber = $rolledNumber;
        $this->rollSequence = $rollSequence;
        $this->diceRollEvaluator = $diceRollEvaluator;
    }

    /**
     * @return Dice
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
    public function getRollSequence()
    {
        return $this->rollSequence;
    }

    /**
     * @return DiceRollEvaluator
     */
    public function getDiceRollEvaluator()
    {
        return $this->diceRollEvaluator;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->diceRollEvaluator->evaluateDiceRoll($this)->getValue();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->getValue();
    }
}
