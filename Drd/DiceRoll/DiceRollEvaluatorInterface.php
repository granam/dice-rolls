<?php
namespace Drd\DiceRoll;

use Granam\Strict\Integer\StrictInteger;

interface DiceRollEvaluatorInterface
{

    /**
     * @param DiceRoll $diceRoll
     * @return StrictInteger
     */
    public function evaluateDiceRoll(DiceRoll $diceRoll);
}
