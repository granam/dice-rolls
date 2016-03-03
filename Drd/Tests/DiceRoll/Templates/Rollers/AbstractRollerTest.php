<?php
namespace Drd\Tests\DiceRoll\Templates\Rollers;

use Drd\DiceRoll\DiceRoll;
use Granam\Tests\Tools\TestWithMockery;

abstract class AbstractRollerTest extends TestWithMockery
{
    const MAX_ROLL_ATTEMPTS = 10000;
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
