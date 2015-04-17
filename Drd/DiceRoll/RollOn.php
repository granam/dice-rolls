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

        if ($this->getRoll()->getBonusRollOn()->happened()) {
            $summary += $this->getRoll()->getBonusRollOn()->getLastRollSummary();
        }

        if ($this->getRoll()->getMalusRollOn()->happened()) {
            $summary += $this->getRoll()->getMalusRollOn()->getLastRollSummary();
        }

        return $summary;
    }

    /**
     * Transforms rolled value into its final value
     *
     * @param DiceRoll $diceRoll
     * @return int
     */
    abstract protected function evaluateDiceRoll(DiceRoll $diceRoll);

    /**
     * @return bool
     */
    public function happened()
    {
        return count($this->getRoll()->getLastStandardDiceRolls()) > 0;
    }
}
