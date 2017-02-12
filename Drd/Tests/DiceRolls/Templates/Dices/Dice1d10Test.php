<?php
namespace Drd\Tests\DiceRolls\Templates\Dices;

use Drd\DiceRolls\Templates\Dices\Dice1d10;

class Dice1d10Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function can_create_instance()
    {
        $instance = new Dice1d10();
        self::assertNotNull($instance);
    }

    /**
     * @test
     * @depends can_create_instance
     */
    public function minimum_is_one()
    {
        $dice = new Dice1d10();
        self::assertSame(1, $dice->getMinimum()->getValue());
    }

    /**
     * @test
     * @depends can_create_instance
     */
    public function maximum_is_six()
    {
        $dice = new Dice1d10();
        self::assertSame(10, $dice->getMaximum()->getValue());
    }
}
