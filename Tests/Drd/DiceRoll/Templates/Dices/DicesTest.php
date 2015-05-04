<?php
namespace Drd\DiceRoll\Templates\Dices;

use Drd\DiceRoll\DiceInterface;
use Granam\Strict\Integer\StrictInteger;

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
     */
    public function without_dices_exception_is_thrown()
    {
        new Dices([]);
    }

    /**
     * @test
     * @expectedException \LogicException
     */
    public function non_dice_parameter_cause_exception()
    {
        new Dices([\Mockery::mock(DiceInterface::class), new \stdClass()]);
    }

    /**
     * @test
     * @expectedException \LogicException
     */
    public function null_as_dice_parameter_cause_exception()
    {
        new Dices([\Mockery::mock(DiceInterface::class), null]);
    }

    /**
     * @test
     */
    public function minimum_is_sum_of_dices_minimum()
    {
        $dices = new Dices([$firstDice = \Mockery::mock(DiceInterface::class), $secondDice = \Mockery::mock(DiceInterface::class)]);
        $firstDice->shouldReceive('getMinimum')
            ->once()
            ->andReturn($firstMinimum = \Mockery::mock(StrictInteger::class));
        $firstMinimum->shouldReceive('getValue')
            ->once()
            ->andReturn($firstMinimumValue = 123);
        $secondDice->shouldReceive('getMinimum')
            ->once()
            ->andReturn($secondMinimum = \Mockery::mock(StrictInteger::class));
        $secondMinimum->shouldReceive('getValue')
            ->once()
            ->andReturn($secondMinimumValue = 456);
        $this->assertSame($firstMinimumValue + $secondMinimumValue, $dices->getMinimum()->getValue());
    }

    /**
     * @test
     */
    public function maximum_is_sum_of_dices_maximum()
    {
        $dices = new Dices([$firstDice = \Mockery::mock(DiceInterface::class), $secondDice = \Mockery::mock(DiceInterface::class)]);
        $firstDice->shouldReceive('getMaximum')
            ->once()
            ->andReturn($firstMaximum = \Mockery::mock(StrictInteger::class));
        $firstMaximum->shouldReceive('getValue')
            ->once()
            ->andReturn($firstMaximumValue = 123);
        $secondDice->shouldReceive('getMaximum')
            ->once()
            ->andReturn($secondMaximum = \Mockery::mock(StrictInteger::class));
        $secondMaximum->shouldReceive('getValue')
            ->once()
            ->andReturn($secondMaximumValue = 456);
        $this->assertSame($firstMaximumValue + $secondMaximumValue, $dices->getMaximum()->getValue());
    }
}
