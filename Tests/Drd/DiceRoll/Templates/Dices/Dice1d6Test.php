<?php
namespace Drd\DiceRoll\Templates\Dices;

class Dice1d6Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function can_create_instance()
    {
        $instance = new Dice1d6();
        $this->assertNotNull($instance);
    }

    /**
     * @test
     * @depends can_create_instance
     */
    public function minimum_is_one()
    {
        $dice = new Dice1d6();
        $this->assertSame(1, $dice->getMinimum()->getValue());
    }

    /**
     * @test
     * @depends can_create_instance
     */
    public function maximum_is_six()
    {
        $dice = new Dice1d6();
        $this->assertSame(6, $dice->getMaximum()->getValue());
    }
}
