<?php
namespace Drd\DiceRoll\Templates\Dices;

class Dice1d4Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function can_create_instance()
    {
        $instance = new Dice1d4();
        $this->assertNotNull($instance);
    }

    /**
     * @test
     * @depends can_create_instance
     */
    public function minimum_is_one()
    {
        $dice = new Dice1d4();
        $this->assertSame(1, $dice->getMinimum()->getValue());
    }

    /**
     * @test
     * @depends can_create_instance
     */
    public function maximum_is_four()
    {
        $dice = new Dice1d4();
        $this->assertSame(4, $dice->getMaximum()->getValue());
    }
}
