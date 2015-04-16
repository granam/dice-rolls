<?php
namespace Drd\DiceRoll\Templates;

class Roll1d4Test extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function can_create_instance()
    {
        $instance = new Roll1d4();
        $this->assertNotNull($instance);

        return $instance;
    }

    /**
     * @param Roll1d4 $roll1d4
     *
     * @test
     * @depends can_create_instance
     */
    public function minimum_is_one(Roll1d4 $roll1d4)
    {
        $this->assertSame(1, $roll1d4->getDice()->getMinimum()->getValue());
    }

    /**
     * @param Roll1d4 $roll1d4
     *
     * @test
     * @depends can_create_instance
     */
    public function maximum_is_four(Roll1d4 $roll1d4)
    {
        $this->assertSame(4, $roll1d4->getDice()->getMaximum()->getValue());
    }

    /**
     * @param Roll1d4 $roll1d4
     *
     * @test
     * @depends can_create_instance
     */
    public function single_roll_only(Roll1d4 $roll1d4)
    {
        $this->assertSame(1, $roll1d4->getNumberOfRolls()->getValue());
        $this->assertGreaterThanOrEqual($roll1d4->getDice()->getMinimum()->getValue(), $roll1d4->roll());
        $this->assertLessThanOrEqual($roll1d4->getDice()->getMaximum()->getValue(), $roll1d4->roll());
    }
}
