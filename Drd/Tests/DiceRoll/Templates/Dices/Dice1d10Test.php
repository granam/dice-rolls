<?php
namespace Drd\Tests\DiceRoll\Templates\Dices;

use Drd\DiceRoll\Templates\Dices\Dice1d10;

class Dice1d10Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function can_create_instance()
    {
        $instance = new Dice1d10();
        $this->assertNotNull($instance);
    }

    /**
     * @test
     * @depends can_create_instance
     */
    public function minimum_is_one()
    {
        $dice = new Dice1d10();
        $this->assertSame(1, $dice->getMinimum()->getValue());
    }

    /**
     * @test
     * @depends can_create_instance
     */
    public function maximum_is_six()
    {
        $dice = new Dice1d10();
        $this->assertSame(10, $dice->getMaximum()->getValue());
    }
}
