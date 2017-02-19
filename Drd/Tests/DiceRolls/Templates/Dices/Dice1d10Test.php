<?php
namespace Drd\Tests\DiceRolls\Templates\Dices;

use Drd\DiceRolls\Templates\Dices\Dice1d10;

class Dice1d10Test extends AbstractPredefinedDiceTest
{
    /**
     * @test
     */
    public function Its_minimum_is_one()
    {
        $dice = new Dice1d10();
        self::assertSame(1, $dice->getMinimum()->getValue());
    }

    /**
     * @test
     */
    public function Its_maximum_is_ten()
    {
        $dice = new Dice1d10();
        self::assertSame(10, $dice->getMaximum()->getValue());
    }
}