<?php
namespace Drd\DiceRoll;

use Granam\Integer\IntegerObject;

interface DiceRollEvaluatorInterface
{

    /**
     * @param DiceRoll $diceRoll
     * @return IntegerObject
     */
    public function evaluateDiceRoll(DiceRoll $diceRoll);
}
