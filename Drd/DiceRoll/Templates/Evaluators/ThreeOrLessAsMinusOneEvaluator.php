<?php
namespace Drd\DiceRoll\Templates\Evaluators;

use Drd\DiceRoll\DiceRoll;
use Drd\DiceRoll\DiceRollEvaluatorInterface;
use Granam\Strict\Object\StrictObject;

class ThreeOrLessAsMinusOneEvaluator extends StrictObject implements DiceRollEvaluatorInterface
{

    /**
     * @param DiceRoll $diceRoll
     * @return int
     */
    public function evaluateDiceRoll(DiceRoll $diceRoll)
    {
        return $diceRoll->getRolledValue()->getValue() < 3
            ? -1
            : 0;
    }
}
