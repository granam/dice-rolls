<?php
namespace Drd\DiceRoll\Templates\Rolls;

class Roll1d6PlusTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function can_create_instance()
    {
        $instance = new Roll1d6Plus();
        $this->assertNotNull($instance);

        return $instance;
    }

    /**
     * @param Roll1d6Plus $roll1d6Plus
     *
     * @test
     * @depends can_create_instance
     */
    public function minimum_is_one(Roll1d6Plus $roll1d6Plus)
    {
        $this->assertSame(1, $roll1d6Plus->getDice()->getMinimum()->getValue());
    }

    /**
     * @param Roll1d6Plus $roll1d6Plus
     *
     * @test
     * @depends can_create_instance
     */
    public function maximum_is_six(Roll1d6Plus $roll1d6Plus)
    {
        $this->assertSame(6, $roll1d6Plus->getDice()->getMaximum()->getValue());
    }

    /**
     * @param Roll1d6Plus $roll1d6Plus
     *
     * @test
     * @depends can_create_instance
     */
    public function at_least_one_roll(Roll1d6Plus $roll1d6Plus)
    {
        $this->assertSame(1, $roll1d6Plus->getNumberOfStandardRolls()->getValue());
        $this->assertGreaterThanOrEqual($roll1d6Plus->getDice()->getMinimum()->getValue(), $roll1d6Plus->roll());
        $this->greaterThanOrEqual(1, count($roll1d6Plus->getLastDiceRolls()));
    }

    /**
     * @param Roll1d6Plus $roll1d6Plus
     *
     * @test
     * @depends can_create_instance
     */
    public function bonus_roll_can_happen(Roll1d6Plus $roll1d6Plus)
    {
        $rolledValue = 0;
        for ($attempt = 1; $attempt < 1000; $attempt++) {
            $rolledValue = $roll1d6Plus->roll();
            if ($rolledValue > 6) {
                break;
            }
        }
        $this->assertGreaterThan(6, $rolledValue);
        $this->assertGreaterThan(1, count($roll1d6Plus->getLastDiceRolls()));
    }
}
