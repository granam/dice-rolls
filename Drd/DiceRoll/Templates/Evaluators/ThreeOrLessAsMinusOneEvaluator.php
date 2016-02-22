<?php
namespace Drd\DiceRoll\Templates\Evaluators;

use Drd\DiceRoll\DiceRoll;
use Drd\DiceRoll\DiceRollEvaluatorInterface;
use Drd\DiceRoll\Templates\Counts\MinusOne;
use Drd\DiceRoll\Templates\Counts\Zero;
use Granam\Integer\IntegerObject;
use Granam\Strict\Object\StrictObject;

class ThreeOrLessAsMinusOneEvaluator extends StrictObject implements DiceRollEvaluatorInterface
{

    /**
     * @param DiceRoll $diceRoll
     * @return IntegerObject
     */
    public function evaluateDiceRoll(DiceRoll $diceRoll)
    {
        return $diceRoll->getRolledNumber()->getValue() <= 3
            ? MinusOne::getIt()
            : Zero::getIt();
    }
}
