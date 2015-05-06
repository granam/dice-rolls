<?php
namespace Drd\DiceRoll\Templates\Rolls;

use Drd\DiceRoll\DiceInterface;
use Drd\DiceRoll\Templates\Evaluators\ThreeOrLessAsMinusOneEvaluator;
use Drd\DiceRoll\Templates\RollOn\Malus1RollOn3Minus;
use Drd\DiceRoll\Templates\RollOn\NoRollOn;
use Granam\Strict\Integer\StrictInteger;

class Roll3MinusAsMinus1RecursiveTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function can_create_instance()
    {
        /** @var DiceInterface|\Mockery\MockInterface $dice */
        $dice = \Mockery::mock(DiceInterface::class);
        $dice->shouldReceive('getMinimum')
            ->atLeast()->once()
            ->andReturn($minimum = \Mockery::mock(StrictInteger::class));
        $minimum->shouldReceive('getValue')
            ->once()
            ->andReturn($minimumValue = 1);
        $dice->shouldReceive('getMaximum')
            ->atLeast()->once()
            ->andReturn($maximum = \Mockery::mock(StrictInteger::class));
        $maximum->shouldReceive('getValue')
            ->once()
            ->andReturn($maximumValue = $minimumValue + 1);
        $instance = new Roll3MinusAsMinus1Recursive($dice);
        $this->assertNotNull($instance);
    }

    /**
     * @return Roll3MinusAsMinus1Recursive
     *
     * @test
     * @depends can_create_instance
     */
    public function returns_given_dice()
    {
        /** @var DiceInterface|\Mockery\MockInterface $dice */
        $dice = \Mockery::mock(DiceInterface::class);
        $dice->shouldReceive('getMinimum')
            ->atLeast()->once()
            ->andReturn($minimum = \Mockery::mock(StrictInteger::class));
        $minimum->shouldReceive('getValue')
            ->once()
            ->andReturn($minimumValue = 1);
        $dice->shouldReceive('getMaximum')
            ->atLeast()->once()
            ->andReturn($maximum = \Mockery::mock(StrictInteger::class));
        $maximum->shouldReceive('getValue')
            ->once()
            ->andReturn($maximumValue = $minimumValue + 1);
        $roll = new Roll3MinusAsMinus1Recursive($dice);
        $this->assertSame($dice, $roll->getDice());

        return $roll;
    }

    /**
     * @param Roll3MinusAsMinus1Recursive $roll
     *
     * @test
     * @depends returns_given_dice
     */
    public function just_a_single_roll(Roll3MinusAsMinus1Recursive $roll)
    {
        $this->assertEquals(1, $roll->getNumberOfRolls()->getValue());
    }

    /**
     * @param Roll3MinusAsMinus1Recursive $roll
     *
     * @test
     * @depends returns_given_dice
     */
    public function dice_roll_builder_uses_proper_evaluator(Roll3MinusAsMinus1Recursive $roll)
    {
        /** @var StrictInteger $rolledNumber */
        $rolledNumber = \Mockery::mock(StrictInteger::class);
        /** @var StrictInteger $rollSequence */
        $rollSequence = \Mockery::mock(StrictInteger::class);
        $diceRoll = $roll->getDiceRollBuilder()->create($roll->getDice(), $rolledNumber, $rollSequence);
        $this->assertInstanceOf(ThreeOrLessAsMinusOneEvaluator::class, $diceRoll->getDiceRollEvaluator());
    }

    /**
     * @param Roll3MinusAsMinus1Recursive $roll
     *
     * @test
     * @depends returns_given_dice
     */
    public function no_bonus_roll(Roll3MinusAsMinus1Recursive $roll)
    {
        $this->assertInstanceOf(NoRollOn::class, $roll->getBonusRollOn());
    }

    /**
     * @param Roll3MinusAsMinus1Recursive $roll
     * @return Roll3MinusAsMinus1Recursive
     *
     * @test
     * @depends returns_given_dice
     */
    public function uses_proper_malus_roll_on(Roll3MinusAsMinus1Recursive $roll)
    {
        $this->assertInstanceOf(Malus1RollOn3Minus::class, $roll->getMalusRollOn());

        return $roll;
    }

    /**
     * @param Roll3MinusAsMinus1Recursive $roll
     *
     * @test
     * @depends uses_proper_malus_roll_on
     */
    public function malus_roll_on_creates_roll_of_tested_type(Roll3MinusAsMinus1Recursive $roll)
    {
        $this->assertInstanceOf(Roll3MinusAsMinus1Recursive::class, $roll->getMalusRollOn()->getRoll());
    }
}
