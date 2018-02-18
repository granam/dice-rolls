<?php
declare(strict_types=1);

namespace DrdPlus\DiceRolls\Templates\DiceRolls;

use DrdPlus\DiceRolls\DiceRoll;
use DrdPlus\DiceRolls\DiceRollEvaluator;
use DrdPlus\DiceRolls\Exceptions\InvalidSequenceNumber;
use DrdPlus\DiceRolls\Templates\Dices\Dice1d6;
use DrdPlus\DiceRolls\Templates\Evaluators\OneToOneEvaluator;
use Granam\Integer\IntegerInterface;
use Granam\Integer\IntegerObject;
use Granam\Integer\PositiveIntegerObject;
use Granam\Integer\Tools\ToInteger;

abstract class AbstractDice1d6Roll extends DiceRoll
{

    /**
     * @param IntegerInterface|int $rolledNumber
     * @param DiceRollEvaluator $diceRollEvaluator
     * @param IntegerInterface|int $sequenceNumber
     * @throws \DrdPlus\DiceRolls\Templates\DiceRolls\Exceptions\Invalid1d6DiceRollValue
     * @throws \DrdPlus\DiceRolls\Exceptions\InvalidSequenceNumber
     */
    public function __construct($rolledNumber, DiceRollEvaluator $diceRollEvaluator, $sequenceNumber = 1)
    {
        $rolledNumber = ToInteger::toPositiveInteger($rolledNumber);
        if ($rolledNumber < 1 || $rolledNumber > 6) {
            throw new Exceptions\Invalid1d6DiceRollValue("Expected value in range 1..6, got {$rolledNumber}");
        }
        $sequenceNumber = ToInteger::toPositiveInteger($sequenceNumber);
        if ($sequenceNumber < 1) {
            throw new InvalidSequenceNumber("Sequence number has to be greater than zero, got {$sequenceNumber}");
        }
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        parent::__construct(
            Dice1d6::getIt(),
            new PositiveIntegerObject($rolledNumber),
            new PositiveIntegerObject($sequenceNumber),
            OneToOneEvaluator::getIt()
        );
    }
}