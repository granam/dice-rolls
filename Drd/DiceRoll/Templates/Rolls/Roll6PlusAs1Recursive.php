<?php
namespace Drd\DiceRoll\Templates\Rolls;

use Drd\DiceRoll\DiceInterface;
use Drd\DiceRoll\DiceRollBuilder;
use Drd\DiceRoll\Roll;
use Drd\DiceRoll\Templates\Evaluators\SixOrMoreAsOneEvaluator;
use Drd\DiceRoll\Templates\RollOn\BonusRollOn12;
use Drd\DiceRoll\Templates\RollOn\NoRollOn;
use Drd\DiceRoll\Templates\Rolls\Builders\Roll6PlusAs1RecursiveBuilder;
use Granam\Strict\Integer\StrictInteger;

class Roll6PlusAs1Recursive extends Roll
{
    public function __construct(DiceInterface $dice)
    {
        parent::__construct(
            $dice, // any given dice is used
            new StrictInteger(1), // just a single roll of the dice
            new DiceRollBuilder(new SixOrMoreAsOneEvaluator()), // rolled value 6+ = 1; value 5- = 0
            new BonusRollOn12( // bonus happens on sum roll value of 12 (both rolls together)
                new Roll6PlusAs1RecursiveBuilder($dice) // in case of bonus the same type of roll happens
            ),
            new NoRollOn() // no malus roll
        );
    }
}
