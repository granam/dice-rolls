<?php
namespace Drd\DiceRoll\Templates\Rolls\Builders;

use Drd\DiceRoll\DiceInterface;
use Drd\DiceRoll\Templates\Rolls\Roll4PlusAs1Recursive;
use Granam\Strict\Integer\StrictInteger;

class Roll4PlusAs1RecursiveBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return Roll1d6PlusBuilder
     *
     * @test
     */
    public function can_create_instance()
    {
        /** @var DiceInterface $dice */
        $dice = \Mockery::mock(DiceInterface::class);
        $instance = new Roll4PlusAs1RecursiveBuilder($dice);
        $this->assertNotNull($instance);
    }

    /**
     * @test
     * @depends can_create_instance
     */
    public function creates_4_plus_recursive_roll()
    {
        /** @var DiceInterface|\Mockery\MockInterface $dice */
        $dice = \Mockery::mock(DiceInterface::class);
        $builder = new Roll4PlusAs1RecursiveBuilder($dice);
        $dice->shouldReceive('getMinimum')
            ->once()
            ->andReturn($minimum = \Mockery::mock(StrictInteger::class));
        $minimum->shouldReceive('getValue')
            ->once()
            ->andReturn($minimumValue = 1);
        $dice->shouldReceive('getMaximum')
            ->once()
            ->andReturn($maximum = \Mockery::mock(StrictInteger::class));
        $maximum->shouldReceive('getValue')
            ->once()
            ->andReturn($maximumValue = $minimumValue + 1);
        $this->assertInstanceOf(Roll4PlusAs1Recursive::class, $builder->createRoll());
    }

    /**
     * @test
     * @depends creates_4_plus_recursive_roll
     */
    public function created_roll_got_the_builder_dice()
    {
        /** @var DiceInterface|\Mockery\MockInterface $dice */
        $dice = \Mockery::mock(DiceInterface::class);
        $builder = new Roll4PlusAs1RecursiveBuilder($dice);
        $dice->shouldReceive('getMinimum')
            ->once()
            ->andReturn($minimum = \Mockery::mock(StrictInteger::class));
        $minimum->shouldReceive('getValue')
            ->once()
            ->andReturn($minimumValue = 1);
        $dice->shouldReceive('getMaximum')
            ->once()
            ->andReturn($maximum = \Mockery::mock(StrictInteger::class));
        $maximum->shouldReceive('getValue')
            ->once()
            ->andReturn($maximumValue = $minimumValue + 1);
        $this->assertSame($dice, $builder->createRoll()->getDice());
    }
}
