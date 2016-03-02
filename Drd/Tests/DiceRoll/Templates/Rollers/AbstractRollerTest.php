<?php
namespace Drd\Tests\DiceRoll\Templates\Rollers;

use Drd\DiceRoll\DiceRoll;

abstract class AbstractRollerTest extends \PHPUnit_Framework_TestCase
{
    const ROLLS_ATTEMPTS_COUNT = 1000;
    const ROLLS_ROUNDS = 5;

    abstract public function I_can_create_it();

    abstract public function I_can_roll_by_it();

    protected function summarizeDiceRolls(array $diceRolls)
    {
        return array_sum(
            array_map(
                function (DiceRoll $diceRoll) {
                    return $diceRoll->getValue();
                },
                $diceRolls
            )
        );
    }
}
