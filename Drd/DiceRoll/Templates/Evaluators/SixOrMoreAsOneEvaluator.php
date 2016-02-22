<?php
namespace Drd\DiceRoll\Templates\Evaluators;

use Drd\DiceRoll\DiceRoll;
use Drd\DiceRoll\DiceRollEvaluatorInterface;
use Drd\DiceRoll\Templates\Counts\One;
use Drd\DiceRoll\Templates\Counts\Zero;
use Granam\Integer\IntegerObject;
use Granam\Strict\Object\StrictObject;

class SixOrMoreAsOneEvaluator extends StrictObject implements DiceRollEvaluatorInterface
{

    /**
     * @param DiceRoll $diceRoll
     * @return IntegerObject
     */
    public function evaluateDiceRoll(DiceRoll $diceRoll)
    {
        return $diceRoll->getRolledNumber()->getValue() >= 6
            ? One::getIt()
            : Zero::getIt();
    }
}
