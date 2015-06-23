<?php
namespace Drd\DiceRoll\Templates\Rolls;

use Drd\DiceRoll\DiceRollBuilder;
use Drd\DiceRoll\Roll;
use Drd\DiceRoll\Templates\Dices\Dice1d6;
use Drd\DiceRoll\Templates\Evaluators\OneToOneEvaluator;
use Drd\DiceRoll\Templates\RollOn\RollOn6;
use Drd\DiceRoll\Templates\RollOn\NoRollOn;
use Drd\DiceRoll\Templates\Rolls\Builders\Roll1d6PlusBuilder;
use Granam\Integer\IntegerObject;

class Roll1d6Plus extends Roll
{
    public function __construct()
    {
        parent::__construct(
            new Dice1d6(),
            new IntegerObject(1),
            new DiceRollBuilder(new OneToOneEvaluator()),
            new RollOn6(new Roll1d6PlusBuilder()), // on 6 rolls recursively continue
            new NoRollOn() // no malus
        );
    }
}
