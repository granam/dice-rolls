<?php
declare(strict_types=1);

namespace DrdPlus\DiceRolls;

use Granam\Integer\IntegerInterface;
use Granam\Integer\PositiveInteger;
use Granam\Strict\Object\StrictObject;

class DiceRoll extends StrictObject implements IntegerInterface
{
    /** @var Dice */
    private $dice;
    /** @var IntegerInterface */
    private $rolledNumber;
    /** @var PositiveInteger */
    private $sequenceNumber;
    /** @var DiceRollEvaluator */
    private $diceRollEvaluator;

    /**
     * @param Dice $dice
     * @param IntegerInterface $rolledNumber
     * @param PositiveInteger $sequenceNumber
     * @param DiceRollEvaluator $diceRollEvaluator
     */
    public function __construct(
        Dice $dice,
        IntegerInterface $rolledNumber,
        PositiveInteger $sequenceNumber,
        DiceRollEvaluator $diceRollEvaluator
    )
    {
        $this->dice = $dice;
        $this->rolledNumber = $rolledNumber;
        $this->sequenceNumber = $sequenceNumber;
        $this->diceRollEvaluator = $diceRollEvaluator;
    }

    /**
     * @return Dice
     */
    public function getDice(): Dice
    {
        return $this->dice;
    }

    /**
     * @return IntegerInterface
     */
    public function getRolledNumber(): IntegerInterface
    {
        return $this->rolledNumber;
    }

    /**
     * @return PositiveInteger
     */
    public function getSequenceNumber(): PositiveInteger
    {
        return $this->sequenceNumber;
    }

    /**
     * @return DiceRollEvaluator
     */
    public function getDiceRollEvaluator(): DiceRollEvaluator
    {
        return $this->diceRollEvaluator;
    }

    /**
     * @return int
     */
    public function getValue(): int
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
