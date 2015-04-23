<?php
namespace Drd\DiceRoll;

interface DiceRollEvaluatorInterface
{

    /**
     * @param DiceRoll $diceRoll
     * @return int
     */
    public function evaluateDiceRoll(DiceRoll $diceRoll);
}
