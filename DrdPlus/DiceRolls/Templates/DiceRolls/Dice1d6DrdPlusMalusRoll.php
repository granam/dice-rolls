<?php
declare(strict_types=1);

namespace DrdPlus\DiceRolls\Templates\DiceRolls;

use DrdPlus\DiceRolls\Templates\Evaluators\ThreeOrLessAsMinusOneZeroOtherwiseEvaluator;
use Granam\Integer\IntegerInterface;

class Dice1d6DrdPlusMalusRoll extends AbstractDice1d6Roll
{

    /**
     * @param IntegerInterface|int $rolledNumber
     * @param IntegerInterface|int $sequenceNumber
     */
    public function __construct($rolledNumber, $sequenceNumber)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        parent::__construct(
            $rolledNumber,
            ThreeOrLessAsMinusOneZeroOtherwiseEvaluator::getIt(),
            $sequenceNumber
        );
    }
}