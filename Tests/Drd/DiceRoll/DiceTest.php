<?php
namespace Drd\DiceRoll;

use Granam\Integer\IntegerObject;

class DiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function can_create_instance()
    {
        /** @var IntegerObject|\Mockery\MockInterface $minimum */
        $minimum = \Mockery::mock(IntegerObject::class);
        $minimum->shouldReceive('getValue')
            ->andReturn(1);
        /** @var IntegerObject|\Mockery\MockInterface $maximum */
        $maximum = \Mockery::mock(IntegerObject::class);
        $maximum->shouldReceive('getValue')
            ->andReturn(2);
        $instance = new Dice($minimum, $maximum);
        $this->assertInstanceOf(Dice::class, $instance);
    }

    /**
     * @test
     * @depends can_create_instance
     */
    public function minimum_same_as_maximum_is_valid()
    {
        /** @var IntegerObject|\Mockery\MockInterface $minimum */
        $minimum = \Mockery::mock(IntegerObject::class);
        $minimum->shouldReceive('getValue')
            ->andReturn($minimumValue = 12345);
        /** @var IntegerObject|\Mockery\MockInterface $maximum */
        $maximum = \Mockery::mock(IntegerObject::class);
        $maximum->shouldReceive('getValue')
            ->andReturn($maximumValue = $minimumValue);
        $this->assertSame($minimumValue, $maximumValue);
        $dice = new Dice($minimum, $maximum);
        $this->assertInstanceOf(Dice::class, $dice);
    }

    /**
     * @test
     * @depends minimum_same_as_maximum_is_valid
     * @expectedException \Drd\DiceRoll\Exceptions\InvalidRange
     */
    public function minimum_greater_than_maximum_cause_exception()
    {
        /** @var IntegerObject|\Mockery\MockInterface $minimum */
        $minimum = \Mockery::mock(IntegerObject::class);
        $minimum->shouldReceive('getValue')
            ->andReturn($minimumValue = 12345);
        /** @var IntegerObject|\Mockery\MockInterface $maximum */
        $maximum = \Mockery::mock(IntegerObject::class);
        $maximum->shouldReceive('getValue')
            ->andReturn($maximumValue = $minimumValue - 1);
        $this->assertLessThan($minimumValue, $maximumValue);
        new Dice($minimum, $maximum);
    }

    /**
     * @test
     * @depends minimum_same_as_maximum_is_valid
     * @expectedException \Drd\DiceRoll\Exceptions\InvalidRange
     */
    public function maximum_lesser_than_one_cause_exception()
    {
        /** @var IntegerObject|\Mockery\MockInterface $minimum */
        $minimum = \Mockery::mock(IntegerObject::class);
        $minimum->shouldReceive('getValue')
            ->andReturn($minimumValue = 0);
        /** @var IntegerObject|\Mockery\MockInterface $maximum */
        $maximum = \Mockery::mock(IntegerObject::class);
        $maximum->shouldReceive('getValue')
            ->andReturn($maximumValue = $minimumValue);
        $this->assertLessThan(1, $maximumValue);
        new Dice($minimum, $maximum);
    }

    /**
     * @test
     * @depends maximum_lesser_than_one_cause_exception
     * @expectedException \Drd\DiceRoll\Exceptions\InvalidRange
     */
    public function minimum_lesser_than_one_cause_exception()
    {
        /** @var IntegerObject|\Mockery\MockInterface $minimum */
        $minimum = \Mockery::mock(IntegerObject::class);
        $minimum->shouldReceive('getValue')
            ->andReturn($minimumValue = 0);
        $this->assertLessThan(1, $minimumValue);
        /** @var IntegerObject|\Mockery\MockInterface $maximum */
        $maximum = \Mockery::mock(IntegerObject::class);
        $maximum->shouldReceive('getValue')
            ->andReturn(12345);
        new Dice($minimum, $maximum);
    }

    /**
     * @test
     * @depends can_create_instance
     */
    public function gives_same_limits_as_given()
    {
        /** @var IntegerObject|\Mockery\MockInterface $minimum */
        $minimum = \Mockery::mock(IntegerObject::class);
        $minimum->shouldReceive('getValue')
            ->andReturn(1);
        /** @var IntegerObject|\Mockery\MockInterface $maximum */
        $maximum = \Mockery::mock(IntegerObject::class);
        $maximum->shouldReceive('getValue')
            ->andReturn(1);
        $dice = new Dice($minimum, $maximum);
        $this->assertSame($minimum, $dice->getMinimum());
        $this->assertSame($maximum, $dice->getMaximum());
    }

}
