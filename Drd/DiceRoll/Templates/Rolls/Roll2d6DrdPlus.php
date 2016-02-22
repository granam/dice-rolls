<?php
namespace Drd\DiceRoll\Templates\Rolls;

use Drd\DiceRoll\DiceRollBuilder;
use Drd\DiceRoll\Roll;
use Drd\DiceRoll\Templates\Counts\Two;
use Drd\DiceRoll\Templates\Dices\Dice1d6;
use Drd\DiceRoll\Templates\Evaluators\OneToOneEvaluator;
use Drd\DiceRoll\Templates\RollOn\RollOn12;
use Drd\DiceRoll\Templates\RollOn\RollOn2;
use Drd\DiceRoll\Templates\Rolls\Builders\Roll3MinusAsMinus1Builder;
use Drd\DiceRoll\Templates\Rolls\Builders\Roll4PlusAs1Builder;

/**
 * 2x1d6; 12 = bonus roll by 1x1d6 => 1-3 = 0, 4-6 = +1 and rolls again; 2 = malus roll by 1x1d6 => 1-3 = -1 and rolls again, 4-6 = 0
 */
class Roll2d6DrdPlus extends Roll
{
    public function __construct()
    {
        $dice1d6 = new Dice1d6();
        parent::__construct(
            $dice1d6,
            Two::getIt(), // number of rolls = 2
            new DiceRollBuilder(new OneToOneEvaluator()), // rolled value remains untouched
            new RollOn12( // bonus happens on sum roll value of 12 (both rolls summarized)
                new Roll4PlusAs1Builder($dice1d6) // bonus roll by 1d6; 1-3 = +0; 4-6 = +1; repeatedly in case of bonus
            ),
            new RollOn2( // malus happens on sum roll of 2 (both rolls summarized)
                new Roll3MinusAsMinus1Builder($dice1d6) // malus roll by 1d6; 1-3 = -1; 4-6 = 0; repeatedly in case of malus
            )
        );
    }
}
