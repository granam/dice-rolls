<?php
namespace Drd\DiceRoll;

class AbstractRollOnTest extends \PHPUnit_Framework_TestCase
{

    protected function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function can_create_inherited_instance()
    {
        /** @var RollBuilderInterface $rollFactory */
        $rollFactory = \Mockery::mock(RollBuilderInterface::class);
        $instance = new TestAbstractRollOn($rollFactory);
        $this->assertInstanceOf(AbstractRollOn::class, $instance);

        return $instance;
    }

    /**
     * @test
     * @depends can_create_inherited_instance
     */
    public function happened_after_roll()
    {
        $roll = \Mockery::mock(Roll::class);
        /** @var RollBuilderInterface|\Mockery\MockInterface $rollFactory */
        $rollFactory = \Mockery::mock(RollBuilderInterface::class);
        $rollFactory->shouldReceive('createRoll')
            ->once()
            ->andReturn($roll);
        $testAbstractRollOn = new TestAbstractRollOn($rollFactory);
        $this->assertFalse($testAbstractRollOn->happened());
        $this->assertSame($roll, $testAbstractRollOn->getRoll());
        $roll->shouldReceive('getLastStandardDiceRolls')
            ->andReturn(true);
        $this->assertTrue($testAbstractRollOn->happened());
    }

}

/** inner */
class TestAbstractRollOn extends AbstractRollOn
{

    public function shouldHappen($rolledValue)
    {
        return true;
    }
}
