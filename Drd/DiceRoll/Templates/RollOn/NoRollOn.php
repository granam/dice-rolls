<?php
namespace Drd\DiceRoll\Templates\RollOn;

use Drd\DiceRoll\DiceRoll;
use Drd\DiceRoll\Roll;
use Drd\DiceRoll\RollOnInterface;

class NoRollOn implements RollOnInterface
{
    /**
     * @param int $rolledValue
     *
     * @return bool
     */
    public function shouldHappen($rolledValue)
    {
        return false;
    }

    /**
     * @return Roll
     */
    public function getRoll()
    {
        throw new \LogicException('This roll-on has no roll.');
    }

    /**
     * Transforms rolled value into its final value
     *
     * @param DiceRoll $diceRoll
     * @return int
     */
    public function evaluateDiceRoll(/** @noinspection PhpUnusedParameterInspection */
        DiceRoll $diceRoll)
    {
        throw new \LogicException('This roll-on is not supposed to evaluate anything.');
    }

    public function getLastRollSummary()
    {
        return 0;
    }

    public function happened()
    {
        return false;
    }

}
