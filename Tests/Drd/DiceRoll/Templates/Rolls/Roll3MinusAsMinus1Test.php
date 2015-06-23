<?php
namespace Drd\DiceRoll\Templates\Rolls;

use Drd\DiceRoll\DiceInterface;
use Drd\DiceRoll\Templates\Evaluators\ThreeOrLessAsMinusOneEvaluator;
use Drd\DiceRoll\Templates\RollOn\RollOn3Minus;
use Drd\DiceRoll\Templates\RollOn\NoRollOn;
use Granam\Integer\IntegerObject;

class Roll3MinusAsMinus1Test extends \PHPUnit_Framework_TestCase
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
            ->andReturn($minimum = \Mockery::mock(IntegerObject::class));
        $minimum->shouldReceive('getValue')
            ->once()
            ->andReturn($minimumValue = 1);
        $dice->shouldReceive('getMaximum')
            ->atLeast()->once()
            ->andReturn($maximum = \Mockery::mock(IntegerObject::class));
        $maximum->shouldReceive('getValue')
            ->once()
            ->andReturn($maximumValue = $minimumValue + 1);
        $instance = new Roll3MinusAsMinus1($dice);
        $this->assertNotNull($instance);
    }

    /**
     * @return Roll3MinusAsMinus1
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
            ->andReturn($minimum = \Mockery::mock(IntegerObject::class));
        $minimum->shouldReceive('getValue')
            ->once()
            ->andReturn($minimumValue = 1);
        $dice->shouldReceive('getMaximum')
            ->atLeast()->once()
            ->andReturn($maximum = \Mockery::mock(IntegerObject::class));
        $maximum->shouldReceive('getValue')
            ->once()
            ->andReturn($maximumValue = $minimumValue + 1);
        $roll = new Roll3MinusAsMinus1($dice);
        $this->assertSame($dice, $roll->getDice());

        return $roll;
    }

    /**
     * @param Roll3MinusAsMinus1 $roll
     *
     * @test
     * @depends returns_given_dice
     */
    public function just_a_single_roll(Roll3MinusAsMinus1 $roll)
    {
        $this->assertEquals(1, $roll->getNumberOfStandardRolls()->getValue());
    }

    /**
     * @param Roll3MinusAsMinus1 $roll
     *
     * @test
     * @depends returns_given_dice
     */
    public function dice_roll_builder_uses_proper_evaluator(Roll3MinusAsMinus1 $roll)
    {
        /** @var IntegerObject $rolledNumber */
        $rolledNumber = \Mockery::mock(IntegerObject::class);
        /** @var IntegerObject $rollSequence */
        $rollSequence = \Mockery::mock(IntegerObject::class);
        $diceRoll = $roll->getDiceRollBuilder()->create($roll->getDice(), $rolledNumber, $rollSequence);
        $this->assertInstanceOf(ThreeOrLessAsMinusOneEvaluator::class, $diceRoll->getDiceRollEvaluator());
    }

    /**
     * @param Roll3MinusAsMinus1 $roll
     *
     * @test
     * @depends returns_given_dice
     */
    public function no_bonus_roll(Roll3MinusAsMinus1 $roll)
    {
        $this->assertInstanceOf(NoRollOn::class, $roll->getBonusRollOn());
    }

    /**
     * @param Roll3MinusAsMinus1 $roll
     * @return Roll3MinusAsMinus1
     *
     * @test
     * @depends returns_given_dice
     */
    public function uses_proper_malus_roll_on(Roll3MinusAsMinus1 $roll)
    {
        $this->assertInstanceOf(RollOn3Minus::class, $roll->getMalusRollOn());

        return $roll;
    }

    /**
     * @param Roll3MinusAsMinus1 $roll
     *
     * @test
     * @depends uses_proper_malus_roll_on
     */
    public function malus_roll_on_creates_roll_of_tested_type(Roll3MinusAsMinus1 $roll)
    {
        $this->assertInstanceOf(Roll3MinusAsMinus1::class, $roll->getMalusRollOn()->getRoll());
    }
}
