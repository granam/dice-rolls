<?php
namespace Drd\DiceRoll\Templates;

class Roll1d6Test extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function can_create_instance()
    {
        $instance = new Roll1d6();
        $this->assertNotNull($instance);

        return $instance;
    }

    /**
     * @param Roll1d6 $roll1d6
     *
     * @test
     * @depends can_create_instance
     */
    public function minimum_is_one(Roll1d6 $roll1d6)
    {
        $this->assertSame(1, $roll1d6->getDice()->getMinimum()->getValue());
    }

    /**
     * @param Roll1d6 $roll1d6
     *
     * @test
     * @depends can_create_instance
     */
    public function maximum_is_six(Roll1d6 $roll1d6)
    {
        $this->assertSame(6, $roll1d6->getDice()->getMaximum()->getValue());
    }

    /**
     * @param Roll1d6 $roll1d6
     *
     * @test
     * @depends can_create_instance
     */
    public function single_roll_only(Roll1d6 $roll1d6)
    {
        $this->assertSame(1, $roll1d6->getNumberOfRolls()->getValue());
        $this->assertGreaterThanOrEqual($roll1d6->getDice()->getMinimum()->getValue(), $roll1d6->roll());
        $this->assertLessThanOrEqual($roll1d6->getDice()->getMaximum()->getValue(), $roll1d6->roll());
    }
}
