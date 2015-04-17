<?php
namespace Drd\DiceRoll\Templates;

use Drd\DiceRoll\DiceRoll;
use Drd\DiceRoll\Roll;
use Drd\DiceRoll\RollOn;

class SameBonusRollOn6 extends RollOn
{
    /**
     * @var Roll
     */
    private $roll;
    /**
     * @var \Closure
     */
    private $rollFactory;

    public function __construct(\Closure $rollFactory)
    {
        $this->rollFactory = $rollFactory;
    }

    /**
     * @param int $rolledValue
     *
     * @return bool
     */
    public function shouldRepeatRoll($rolledValue)
    {
        return intval($rolledValue) === 6;
    }

    /**
     * @return Roll
     */
    public function getRoll()
    {
        if (!isset($this->roll)) {
            $this->roll = $this->createRoll();
        }

        return $this->roll;
    }

    private function createRoll()
    {
        $rollFactory = $this->rollFactory;
        $roll = $rollFactory();
        if (!is_a($roll, Roll::class)) {
            throw new \LogicException(
                'Roll factory does not returned a roll, but ' . gettype($roll)
                . is_object($roll)
                    ? '; ' . get_class($roll)
                    : ''
            );
        }

        return $roll;
    }

    /**
     * Transforms rolled value into its final value
     *
     * @param DiceRoll $diceRoll
     * @return int
     */
    protected function evaluateDiceRoll(DiceRoll $diceRoll)
    {
        return $diceRoll->getRolledValue()->getValue();
    }

}
