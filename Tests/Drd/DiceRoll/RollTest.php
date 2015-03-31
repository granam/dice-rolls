<?php
namespace Drd\DiceRoll;

use Granam\Strict\Integer\StrictInteger;

class RollTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function can_create_instance()
    {
        $dice = \Mockery::mock(Dice::class);
        $dice->shouldReceive('getMinimum')
            ->andReturn($minimum = \Mockery::mock(StrictInteger::class));
        $minimum->shouldReceive('getValue')
            ->andReturn(1);
        $dice->shouldReceive('getMaximum')
            ->andReturn($maximum = \Mockery::mock(StrictInteger::class));
        $maximum->shouldReceive('getValue')
            ->andReturn(2);
        $instance = new Roll($dices = [$dice]);
        $this->assertInstanceOf(Roll::class, $instance);
        $this->assertSame($dices, $instance->getDices());
    }

    /**
     * @test
     * @depends can_create_instance
     */
    public function default_values_as_expected()
    {
        $dice = \Mockery::mock(Dice::class);
        $dice->shouldReceive('getMinimum')
            ->andReturn($minimum = \Mockery::mock(StrictInteger::class));
        $minimum->shouldReceive('getValue')
            ->andReturn(1);
        $dice->shouldReceive('getMaximum')
            ->andReturn($maximum = \Mockery::mock(StrictInteger::class));
        $maximum->shouldReceive('getValue')
            ->andReturn(2);
        $roll = new Roll([$dice]);
        $this->assertInstanceOf(Roll::class, $roll);
        $this->assertSame(1, $roll->getRollCount());
        $this->assertSame(0 /* never */, $roll->getRepeatOnValue());
    }
}
