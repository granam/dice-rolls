<?php
namespace Drd\DiceRoll\Templates\Dices;

use Drd\DiceRoll\DiceInterface;
use Granam\Integer\IntegerObject;

class DicesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function can_create_instance()
    {
        $instance = new Dices([\Mockery::mock(DiceInterface::class)]);
        $this->assertNotNull($instance);
    }

    /**
     * @test
     * @expectedException \LogicException
     * @depends can_create_instance
     */
    public function without_dices_exception_is_thrown()
    {
        new Dices([]);
    }

    /**
     * @test
     * @expectedException \LogicException
     * @depends can_create_instance
     */
    public function non_dice_parameter_cause_exception()
    {
        new Dices([\Mockery::mock(DiceInterface::class), new \stdClass()]);
    }

    /**
     * @test
     * @expectedException \LogicException
     * @depends can_create_instance
     */
    public function null_as_dice_parameter_cause_exception()
    {
        new Dices([\Mockery::mock(DiceInterface::class), null]);
    }

    /**
     * @test
     * @depends can_create_instance
     */
    public function minimum_is_sum_of_dices_minimum()
    {
        $dices = new Dices([$firstDice = \Mockery::mock(DiceInterface::class), $secondDice = \Mockery::mock(DiceInterface::class)]);
        $firstDice->shouldReceive('getMinimum')
            ->once()
            ->andReturn($firstMinimum = \Mockery::mock(IntegerObject::class));
        $firstMinimum->shouldReceive('getValue')
            ->once()
            ->andReturn($firstMinimumValue = 123);
        $secondDice->shouldReceive('getMinimum')
            ->once()
            ->andReturn($secondMinimum = \Mockery::mock(IntegerObject::class));
        $secondMinimum->shouldReceive('getValue')
            ->once()
            ->andReturn($secondMinimumValue = 456);
        $this->assertSame($firstMinimumValue + $secondMinimumValue, $dices->getMinimum()->getValue());
    }

    /**
     * @test
     * @depends can_create_instance
     */
    public function maximum_is_sum_of_dices_maximum()
    {
        $dices = new Dices([$firstDice = \Mockery::mock(DiceInterface::class), $secondDice = \Mockery::mock(DiceInterface::class)]);
        $firstDice->shouldReceive('getMaximum')
            ->once()
            ->andReturn($firstMaximum = \Mockery::mock(IntegerObject::class));
        $firstMaximum->shouldReceive('getValue')
            ->once()
            ->andReturn($firstMaximumValue = 123);
        $secondDice->shouldReceive('getMaximum')
            ->once()
            ->andReturn($secondMaximum = \Mockery::mock(IntegerObject::class));
        $secondMaximum->shouldReceive('getValue')
            ->once()
            ->andReturn($secondMaximumValue = 456);
        $this->assertSame($firstMaximumValue + $secondMaximumValue, $dices->getMaximum()->getValue());
    }
}
