<?php
namespace Drd\DiceRoll\Templates\Rolls;

class Roll2d6PlusBonus1Plus1On12Malus1MinusOn2Test extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function can_create_instance()
    {
        $instance = new Roll2d6PlusBonus1Plus1On12Malus1MinusOn2();
        $this->assertNotNull($instance);

        return $instance;
    }

    /**
     * @param Roll2d6PlusBonus1Plus1On12Malus1MinusOn2 $roll2d6Plus1Minus
     *
     * @test
     * @depends can_create_instance
     */
    public function minimum_is_one(Roll2d6PlusBonus1Plus1On12Malus1MinusOn2 $roll2d6Plus1Minus)
    {
        $this->assertSame(1, $roll2d6Plus1Minus->getDice()->getMinimum()->getValue());
    }

    /**
     * @param Roll2d6PlusBonus1Plus1On12Malus1MinusOn2 $roll2d6Plus1Minus
     *
     * @test
     * @depends can_create_instance
     */
    public function maximum_is_six(Roll2d6PlusBonus1Plus1On12Malus1MinusOn2 $roll2d6Plus1Minus)
    {
        $this->assertSame(6, $roll2d6Plus1Minus->getDice()->getMaximum()->getValue());
    }

    /**
     * @param Roll2d6PlusBonus1Plus1On12Malus1MinusOn2 $roll2d6Plus1Minus
     *
     * @test
     * @depends can_create_instance
     */
    public function at_least_one_roll(Roll2d6PlusBonus1Plus1On12Malus1MinusOn2 $roll2d6Plus1Minus)
    {
        $this->assertSame(2, $roll2d6Plus1Minus->getNumberOfRolls()->getValue());
        $this->assertGreaterThanOrEqual($roll2d6Plus1Minus->getDice()->getMinimum()->getValue(), $roll2d6Plus1Minus->roll());
        $this->greaterThanOrEqual(2, count($roll2d6Plus1Minus->getLastDiceRolls()));
    }

    /**
     * @param Roll2d6PlusBonus1Plus1On12Malus1MinusOn2 $roll2d6Plus1Minus
     *
     * @test
     * @depends can_create_instance
     */
    public function bonus_roll_can_happen(Roll2d6PlusBonus1Plus1On12Malus1MinusOn2 $roll2d6Plus1Minus)
    {
        $rolledValue = 0;
        for ($attempt = 1; $attempt < 1000; $attempt++) {
            $rolledValue = $roll2d6Plus1Minus->roll();
            if ($rolledValue > 6) {
                break;
            }
        }
        $this->assertGreaterThan(6, $rolledValue);
        $this->assertGreaterThan(1, count($roll2d6Plus1Minus->getLastDiceRolls()));
    }
}
