<?php
namespace Drd\DiceRoll;

use Granam\Integer\IntegerInterface;

interface DiceRollEvaluator
{

    /**
     * @param DiceRoll $diceRoll
     * @return IntegerInterface
     */
    public function evaluateDiceRoll(DiceRoll $diceRoll);
}
