<?php
namespace Drd\DiceRoll\Templates\Rolls;

use Drd\DiceRoll\DiceRollBuilder;
use Drd\DiceRoll\Roll;
use Drd\DiceRoll\Templates\Dices\Dice1d6;
use Drd\DiceRoll\Templates\Evaluators\OneToOneEvaluator;
use Drd\DiceRoll\Templates\RollOn\BonusRollOn6;
use Drd\DiceRoll\Templates\RollOn\NoRollOn;
use Granam\Strict\Integer\StrictInteger;

class Roll1d6Plus extends Roll
{
    public function __construct()
    {
        parent::__construct(
            new Dice1d6(),
            new StrictInteger(1),
            new DiceRollBuilder(new OneToOneEvaluator()),
            new BonusRollOn6(new Roll1d6PlusBuilder()), // bonus
            new NoRollOn() // no malus
        );
    }
}
