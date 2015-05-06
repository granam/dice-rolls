<?php
namespace Drd\DiceRoll\Templates\Rolls;

use Drd\DiceRoll\DiceInterface;
use Drd\DiceRoll\Templates\Evaluators\SixOrMoreAsOneEvaluator;
use Drd\DiceRoll\Templates\RollOn\RollOn12;
use Drd\DiceRoll\Templates\RollOn\NoRollOn;
use Granam\Strict\Integer\StrictInteger;

class Roll6PlusAs1Test extends \PHPUnit_Framework_TestCase
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
        $instance = new Roll6PlusAs1($dice);
        $this->assertNotNull($instance);
    }

    /**
     * @return Roll6PlusAs1
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
        $roll = new Roll6PlusAs1($dice);
        $this->assertSame($dice, $roll->getDice());

        return $roll;
    }

    /**
     * @param Roll6PlusAs1 $roll
     *
     * @test
     * @depends returns_given_dice
     */
    public function just_a_single_roll(Roll6PlusAs1 $roll)
    {
        $this->assertEquals(1, $roll->getNumberOfStandardRolls()->getValue());
    }

    /**
     * @param Roll6PlusAs1 $roll
     *
     * @test
     * @depends returns_given_dice
     */
    public function dice_roll_builder_uses_proper_evaluator(Roll6PlusAs1 $roll)
    {
        /** @var StrictInteger $rolledNumber */
        $rolledNumber = \Mockery::mock(StrictInteger::class);
        /** @var StrictInteger $rollSequence */
        $rollSequence = \Mockery::mock(StrictInteger::class);
        $diceRoll = $roll->getDiceRollBuilder()->create($roll->getDice(), $rolledNumber, $rollSequence);
        $this->assertInstanceOf(SixOrMoreAsOneEvaluator::class, $diceRoll->getDiceRollEvaluator());
    }

    /**
     * @param Roll6PlusAs1 $roll
     * @return Roll6PlusAs1
     *
     * @test
     * @depends returns_given_dice
     */
    public function uses_proper_bonus_roll_on(Roll6PlusAs1 $roll)
    {
        $this->assertInstanceOf(RollOn12::class, $roll->getBonusRollOn());

        return $roll;
    }

    /**
     * @param Roll6PlusAs1 $roll
     *
     * @test
     * @depends uses_proper_bonus_roll_on
     */
    public function bonus_roll_on_creates_roll_of_tested_type(Roll6PlusAs1 $roll)
    {
        $this->assertInstanceOf(Roll6PlusAs1::class, $roll->getBonusRollOn()->getRoll());
    }

    /**
     * @param Roll6PlusAs1 $roll
     *
     * @test
     * @depends returns_given_dice
     */
    public function no_malus_roll(Roll6PlusAs1 $roll)
    {
        $this->assertInstanceOf(NoRollOn::class, $roll->getMalusRollOn());
    }

}
