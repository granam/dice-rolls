<?php
namespace Drd\DiceRoll\Templates\Rolls;

use Drd\DiceRoll\DiceInterface;
use Drd\DiceRoll\DiceRollBuilder;
use Drd\DiceRoll\Roll;
use Drd\DiceRoll\Templates\Evaluators\ThreeOrLessAsMinusOneEvaluator;
use Drd\DiceRoll\Templates\RollOn\Malus1RollOn3Minus;
use Drd\DiceRoll\Templates\RollOn\NoRollOn;
use Drd\DiceRoll\Templates\Rolls\Builders\Roll3MinusAsMinus1Builder;
use Granam\Strict\Integer\StrictInteger;

class Roll3MinusAsMinus1 extends Roll
{
    public function __construct(DiceInterface $dice)
    {
        parent::__construct(
            $dice,
            new StrictInteger(1), // just a single roll of the dice
            new DiceRollBuilder(new ThreeOrLessAsMinusOneEvaluator()), // value of 1-3 is turned into malus -1
            new NoRollOn(), // no bonus roll
            new Malus1RollOn3Minus( // in case of malus (-1) rolling continues, otherwise rolling stops
                new Roll3MinusAsMinus1Builder($dice) // in case of bonus the same type of roll happens
            )
        );
    }
}
