<?php
namespace Drd\Tests\DiceRoll\Templates\Dices;

use Drd\DiceRoll\Dice;
use Drd\DiceRoll\Templates\Dices\Dices;
use Granam\Integer\IntegerObject;

class DicesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_create_it()
    {
        $instance = new Dices([\Mockery::mock(Dice::class)]);
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
        new Dices([\Mockery::mock(Dice::class), new \stdClass()]);
    }

    /**
     * @test
     * @expectedException \LogicException
     */
    public function null_as_dice_parameter_cause_exception()
    {
        new Dices([\Mockery::mock(Dice::class), null]);
    }

    /**
     * @test
     */
    public function minimum_is_sum_of_dices_minimum()
    {
        $dices = new Dices([$firstDice = \Mockery::mock(Dice::class), $secondDice = \Mockery::mock(Dice::class)]);
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
     */
    public function maximum_is_sum_of_dices_maximum()
    {
        $dices = new Dices([$firstDice = \Mockery::mock(Dice::class), $secondDice = \Mockery::mock(Dice::class)]);
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
