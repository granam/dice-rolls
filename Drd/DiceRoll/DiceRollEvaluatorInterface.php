<?php
namespace Drd\DiceRoll;

use Granam\Integer\IntegerInterface;

interface DiceRollEvaluatorInterface
{

    /**
     * @param DiceRoll $diceRoll
     * @return IntegerInterface
     */
    public function evaluateDiceRoll(DiceRoll $diceRoll);
}
