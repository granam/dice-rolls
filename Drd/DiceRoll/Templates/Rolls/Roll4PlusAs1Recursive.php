<?php
namespace Drd\DiceRoll\Templates\Rolls;

use Drd\DiceRoll\DiceInterface;
use Drd\DiceRoll\DiceRollBuilder;
use Drd\DiceRoll\Roll;
use Drd\DiceRoll\Templates\Evaluators\FourOrMoreAsOneEvaluator;
use Drd\DiceRoll\Templates\RollOn\Bonus1RollOn4Plus;
use Drd\DiceRoll\Templates\RollOn\NoRollOn;
use Drd\DiceRoll\Templates\Rolls\Builders\Roll4PlusAs1RecursiveBuilder;
use Granam\Strict\Integer\StrictInteger;

class Roll4PlusAs1Recursive extends Roll
{
    public function __construct(DiceInterface $dice)
    {
        parent::__construct(
            $dice,
            new StrictInteger(1), // just a single roll of the dice
            new DiceRollBuilder(new FourOrMoreAsOneEvaluator()), // rolled value 4+ = +1, 3- = 0
            new Bonus1RollOn4Plus( // recursion -> 4 => roll again
                new Roll4PlusAs1RecursiveBuilder($dice) // in case of bonus the same type of roll happens
            ),
            new NoRollOn() // no malus roll
        );
    }
}
