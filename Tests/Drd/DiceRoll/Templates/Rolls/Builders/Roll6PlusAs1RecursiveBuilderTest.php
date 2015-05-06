<?php
namespace Drd\DiceRoll\Templates\Rolls\Builders;

use Drd\DiceRoll\DiceInterface;
use Drd\DiceRoll\Templates\Rolls\Roll6PlusAs1Recursive;
use Granam\Strict\Integer\StrictInteger;

class Roll6PlusAs1RecursiveBuilderTest extends \PHPUnit_Framework_TestCase
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
        $instance = new Roll6PlusAs1RecursiveBuilder($dice);
        $this->assertNotNull($instance);
    }

    /**
     * @test
     * @depends can_create_instance
     */
    public function creates_6_plus_recursive_roll()
    {
        /** @var DiceInterface|\Mockery\MockInterface $dice */
        $dice = \Mockery::mock(DiceInterface::class);
        $builder = new Roll6PlusAs1RecursiveBuilder($dice);
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
        $this->assertInstanceOf(Roll6PlusAs1Recursive::class, $builder->createRoll());
    }

    /**
     * @test
     * @depends creates_6_plus_recursive_roll
     */
    public function created_roll_got_the_builder_dice()
    {
        /** @var DiceInterface|\Mockery\MockInterface $dice */
        $dice = \Mockery::mock(DiceInterface::class);
        $builder = new Roll6PlusAs1RecursiveBuilder($dice);
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
