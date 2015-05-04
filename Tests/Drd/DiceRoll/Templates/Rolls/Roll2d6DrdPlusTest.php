<?php
namespace Drd\DiceRoll\Templates\Rolls;

class Roll2d6DrdPlusTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function can_create_instance()
    {
        $instance = new Roll2d6DrdPlus();
        $this->assertNotNull($instance);

        return $instance;
    }

    /**
     * @param Roll2d6DrdPlus $roll2d6DrdPlus
     *
     * @test
     * @depends can_create_instance
     */
    public function minimum_is_one(Roll2d6DrdPlus $roll2d6DrdPlus)
    {
        $this->assertSame(1, $roll2d6DrdPlus->getDice()->getMinimum()->getValue());
    }

    /**
     * @param Roll2d6DrdPlus $roll2d6DrdPlus
     *
     * @test
     * @depends can_create_instance
     */
    public function maximum_is_six(Roll2d6DrdPlus $roll2d6DrdPlus)
    {
        $this->assertSame(6, $roll2d6DrdPlus->getDice()->getMaximum()->getValue());
    }

    /**
     * @param Roll2d6DrdPlus $roll2d6DrdPlus
     *
     * @test
     * @depends can_create_instance
     */
    public function at_least_one_roll(Roll2d6DrdPlus $roll2d6DrdPlus)
    {
        $this->assertSame(2, $roll2d6DrdPlus->getNumberOfRolls()->getValue());
        $this->assertGreaterThanOrEqual($roll2d6DrdPlus->getDice()->getMinimum()->getValue(), $roll2d6DrdPlus->roll());
        $this->greaterThanOrEqual(2, count($roll2d6DrdPlus->getLastDiceRolls()));
    }

    /**
     * @param Roll2d6DrdPlus $roll2d6DrdPlus
     *
     * @test
     * @depends can_create_instance
     */
    public function bonus_roll_can_happen(Roll2d6DrdPlus $roll2d6DrdPlus)
    {
        $rolledValue = 0;
        for ($attempt = 1; $attempt < 1000; $attempt++) {
            $rolledValue = $roll2d6DrdPlus->roll();
            if ($rolledValue > 6) {
                break;
            }
        }
        $this->assertGreaterThan(6, $rolledValue);
        $this->assertGreaterThan(1, count($roll2d6DrdPlus->getLastDiceRolls()));
    }
}
