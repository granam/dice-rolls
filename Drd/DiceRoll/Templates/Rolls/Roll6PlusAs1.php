<?php
namespace Drd\DiceRoll\Templates\Rolls;

use Drd\DiceRoll\DiceInterface;
use Drd\DiceRoll\DiceRollBuilder;
use Drd\DiceRoll\Roll;
use Drd\DiceRoll\Templates\Counts\One;
use Drd\DiceRoll\Templates\Evaluators\SixOrMoreAsOneEvaluator;
use Drd\DiceRoll\Templates\RollOn\RollOn12;
use Drd\DiceRoll\Templates\RollOn\NoRollOn;
use Drd\DiceRoll\Templates\Rolls\Builders\Roll6PlusAs1Builder;

class Roll6PlusAs1 extends Roll
{
    public function __construct(DiceInterface $dice)
    {
        parent::__construct(
            $dice, // any given dice is used
            One::getIt(), // just a single roll of the dice
            new DiceRollBuilder(new SixOrMoreAsOneEvaluator()), // rolled value 6+ = 1; value 5- = 0
            new RollOn12( // bonus happens on sum roll value of 12 (both rolls together)
                new Roll6PlusAs1Builder($dice) // in case of bonus the same type of roll happens
            ),
            new NoRollOn() // no malus roll
        );
    }
}
