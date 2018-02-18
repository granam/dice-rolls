<?php
declare(strict_types=1);

namespace DrdPlus\DiceRolls\Templates\DiceRolls;

use DrdPlus\DiceRolls\Templates\Evaluators\FourOrMoreAsOneZeroOtherwiseEvaluator;
use Granam\Integer\IntegerInterface;

class Dice1d6DrdPlusBonusRoll extends AbstractDice1d6Roll
{

    /**
     * @param IntegerInterface|int $rolledNumber
     * @param IntegerInterface|int $sequenceNumber
     * @throws \DrdPlus\DiceRolls\Templates\DiceRolls\Exceptions\Invalid1d6DiceRollValue
     * @throws \DrdPlus\DiceRolls\Exceptions\InvalidSequenceNumber
     */
    public function __construct($rolledNumber, $sequenceNumber)
    {
        parent::__construct(
            $rolledNumber,
            FourOrMoreAsOneZeroOtherwiseEvaluator::getIt(),
            $sequenceNumber
        );
    }
}