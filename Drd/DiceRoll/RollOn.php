<?php
namespace Drd\DiceRoll;

abstract class RollOn implements RollOnInterface
{

    /**
     * @return int
     */
    public function getLastRollSummary()
    {
        $summary = 0;
        foreach ($this->getRoll()->getLastStandardDiceRolls() as $diceRoll) {
            $summary += $this->evaluateDiceRoll($diceRoll);
        }

        return $summary + $this->getRoll()->getBonusRollOn()->getLastRollSummary() + $this->getRoll()->getMalusRollOn()->getLastRollSummary();
    }

    /**
     * Transforms rolled value into its final value
     *
     * @param DiceRoll $diceRoll
     * @return int
     */
    abstract protected function evaluateDiceRoll(DiceRoll $diceRoll);
}
