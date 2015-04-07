<?php
namespace Drd\DiceRoll\Templates;

class Roll2d6PlusTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function can_create_instance()
    {
        $instance = new Roll2d6Plus();
        $this->assertNotNull($instance);

        return $instance;
    }

    /**
     * @param Roll2d6Plus $roll2d6Plus
     *
     * @test
     * @depends can_create_instance
     */
    public function minimum_is_one(Roll2d6Plus $roll2d6Plus)
    {
        $this->assertSame(1, $roll2d6Plus->getDice()->getMinimum()->getValue());
    }

    /**
     * @param Roll2d6Plus $roll2d6Plus
     *
     * @test
     * @depends can_create_instance
     */
    public function maximum_is_six(Roll2d6Plus $roll2d6Plus)
    {
        $this->assertSame(6, $roll2d6Plus->getDice()->getMaximum()->getValue());
    }

    /**
     * @param Roll2d6Plus $roll2d6Plus
     *
     * @test
     * @depends can_create_instance
     */
    public function at_least_two_rolls(Roll2d6Plus $roll2d6Plus)
    {
        $this->assertSame(2, $roll2d6Plus->getRollNumber()->getValue());
        $this->assertSame(6, $roll2d6Plus->getRepeatOnValue()->getValue());
        $this->assertGreaterThanOrEqual($roll2d6Plus->getDice()->getMinimum()->getValue(), $roll2d6Plus->roll());
        $this->assertGreaterThanOrEqual($roll2d6Plus->getDice()->getMinimum()->getValue() * 2, $roll2d6Plus->roll());
        $this->greaterThanOrEqual(2, count($roll2d6Plus->getLastDiceRolls()));
    }
}
