<?php
namespace Drd\DiceRoll\Templates\Rolls;

use Drd\DiceRoll\DiceRollBuilder;
use Drd\DiceRoll\Roll;
use Drd\DiceRoll\Templates\Dices\Dice1d4;
use Drd\DiceRoll\Templates\Evaluators\OneToOneEvaluator;
use Drd\DiceRoll\Templates\RollOn\NoRollOn;
use Granam\Strict\Integer\StrictInteger;

class Roll1d4 extends Roll
{
    public function __construct()
    {
        $noRollOn = new NoRollOn();
        parent::__construct(
            new Dice1d4(),
            new StrictInteger(1),
            new DiceRollBuilder(new OneToOneEvaluator()),
            $noRollOn,
            $noRollOn
        );
    }
}
