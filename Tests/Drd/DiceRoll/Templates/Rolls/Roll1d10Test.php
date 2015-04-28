<?php
namespace Drd\DiceRoll\Templates\Rolls;

class Roll1d10Test extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function can_create_instance()
    {
        $instance = new Roll1d10();
        $this->assertNotNull($instance);

        return $instance;
    }

    /**
     * @param Roll1d10 $roll1d10
     *
     * @test
     * @depends can_create_instance
     */
    public function minimum_is_one(Roll1d10 $roll1d10)
    {
        $this->assertSame(1, $roll1d10->getDice()->getMinimum()->getValue());
    }

    /**
     * @param Roll1d10 $roll1d10
     *
     * @test
     * @depends can_create_instance
     */
    public function maximum_is_ten(Roll1d10 $roll1d10)
    {
        $this->assertSame(10, $roll1d10->getDice()->getMaximum()->getValue());
    }

    /**
     * @param Roll1d10 $roll1d10
     *
     * @test
     * @depends can_create_instance
     */
    public function single_roll_only(Roll1d10 $roll1d10)
    {
        $this->assertSame(1, $roll1d10->getNumberOfRolls()->getValue());
        $this->assertGreaterThanOrEqual($roll1d10->getDice()->getMinimum()->getValue(), $roll1d10->roll());
        $this->assertLessThanOrEqual($roll1d10->getDice()->getMaximum()->getValue(), $roll1d10->roll());
    }
}
