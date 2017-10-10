<?php
declare(strict_types=1);

namespace DrdPlus\DiceRolls\Templates\DiceRolls;

use DrdPlus\DiceRolls\DiceRoll;
use DrdPlus\DiceRolls\Templates\Dices\Dice1d6;
use DrdPlus\DiceRolls\Templates\Evaluators\OneToOneEvaluator;
use Granam\Integer\IntegerInterface;
use Granam\Integer\IntegerObject;

class Dice1d6Roll extends DiceRoll
{

    /**
     * @param IntegerInterface $rolledNumber
     */
    public function __construct(IntegerInterface $rolledNumber)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        parent::__construct(Dice1d6::getIt(), $rolledNumber, new IntegerObject(1), OneToOneEvaluator::getIt());
    }
}