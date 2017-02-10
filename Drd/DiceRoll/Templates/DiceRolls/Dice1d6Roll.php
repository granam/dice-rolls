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
     * @param Dice1d6 $dice1D6
     * @param IntegerInterface $rolledNumber
     */
    public function __construct(Dice1d6 $dice1D6, IntegerInterface $rolledNumber)
    {
        parent::__construct($dice1D6, $rolledNumber, new IntegerObject(1), OneToOneEvaluator::getIt());
    }
}