<?php
namespace Drd\DiceRoll\Templates\Evaluators;

use Drd\DiceRoll\DiceRoll;
use Drd\DiceRoll\DiceRollEvaluatorInterface;
use Granam\Strict\Object\StrictObject;

class SixOrMoreAsOneEvaluator extends StrictObject implements DiceRollEvaluatorInterface
{

    /**
     * @param DiceRoll $diceRoll
     * @return int
     */
    public function evaluateDiceRoll(DiceRoll $diceRoll)
    {
        return $diceRoll->getRolledValue()->getValue() >= 6
            ? 1
            : 0;
    }
}
