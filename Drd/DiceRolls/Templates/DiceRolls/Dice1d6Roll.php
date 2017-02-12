<?php
namespace Drd\DiceRolls\Templates\DiceRolls;

use Drd\DiceRolls\DiceRoll;
use Drd\DiceRolls\Templates\Dices\Dice1d6;
use Drd\DiceRolls\Templates\Evaluators\OneToOneEvaluator;
use Granam\Integer\IntegerInterface;
use Granam\Integer\IntegerObject;

class Dice1d6Roll extends DiceRoll
{

    /**
     * @param IntegerInterface $rolledNumber
     */
    public function __construct(IntegerInterface $rolledNumber)
    {
        parent::__construct(Dice1d6::getIt(), $rolledNumber, new IntegerObject(1), OneToOneEvaluator::getIt());
    }
}