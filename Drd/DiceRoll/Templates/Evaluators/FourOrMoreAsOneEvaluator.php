<?php
namespace Drd\DiceRoll\Templates\Evaluators;

use Drd\DiceRoll\DiceRoll;
use Drd\DiceRoll\DiceRollEvaluatorInterface;
use Granam\Strict\Integer\StrictInteger;
use Granam\Strict\Object\StrictObject;

class FourOrMoreAsOneEvaluator extends StrictObject implements DiceRollEvaluatorInterface
{

    /**
     * @param DiceRoll $diceRoll
     * @return StrictInteger
     */
    public function evaluateDiceRoll(DiceRoll $diceRoll)
    {
        return $diceRoll->getRolledNumber()->getValue() >= 4
            ? new StrictInteger(1)
            : new StrictInteger(0);
    }
}
