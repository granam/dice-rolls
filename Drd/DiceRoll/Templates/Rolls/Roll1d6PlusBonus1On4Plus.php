<?php
namespace Drd\DiceRoll\Templates\Rolls;

use Drd\DiceRoll\DiceRollBuilder;
use Drd\DiceRoll\Roll;
use Drd\DiceRoll\Templates\Dices\Dice1d6;
use Drd\DiceRoll\Templates\Evaluators\OneToOneEvaluator;
use Drd\DiceRoll\Templates\RollOn\RollOn4Plus;
use Drd\DiceRoll\Templates\RollOn\NoRollOn;
use Drd\DiceRoll\Templates\Rolls\Builders\Roll4PlusAs1Builder;
use Granam\Integer\IntegerObject;

class Roll1d6PlusBonus1On4Plus extends Roll
{
    public function __construct()
    {
        $dice1d6 = new Dice1d6();
        parent::__construct(
            $dice1d6,
            new IntegerObject(1), // just a single roll of the dice
            new DiceRollBuilder(new OneToOneEvaluator()), // rolled value = final roll value
            new RollOn4Plus(new Roll4PlusAs1Builder($dice1d6)), // 4-6 => roll again; bonus roll 1d6, 4-6 = +1 and roll again
            new NoRollOn() // no malus roll
        );
    }
}
