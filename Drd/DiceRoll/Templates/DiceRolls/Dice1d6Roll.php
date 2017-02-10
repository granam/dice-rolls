<?php
namespace Drd\DiceRoll\Templates\DiceRolls;

use Drd\DiceRoll\DiceRoll;
use Drd\DiceRoll\Templates\Dices\Dice1d6;
use Drd\DiceRoll\Templates\Evaluators\OneToOneEvaluator;
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