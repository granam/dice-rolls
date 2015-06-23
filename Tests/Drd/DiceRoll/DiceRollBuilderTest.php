<?php
namespace Drd\DiceRoll;

use Granam\Integer\IntegerObject;

class DiceRollBuilderTest extends \PHPUnit_Framework_TestCase
{

    protected function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function can_create_instance()
    {
        /** @var DiceRollEvaluatorInterface $diceRollEvaluator */
        $diceRollEvaluator = \Mockery::mock(DiceRollEvaluatorInterface::class);
        $instance = new DiceRollBuilder($diceRollEvaluator);
        $this->assertNotNull($instance);
        $this->assertSame($diceRollEvaluator, $instance->getDiceRollEvaluator());

        return $instance;
    }

    /**
     * @param DiceRollBuilder $diceRollBuilder
     *
     * @test
     * @depends can_create_instance
     */
    public function can_create_dice_roll(DiceRollBuilder $diceRollBuilder)
    {
        /** @var Dice $dice */
        $dice = \Mockery::mock(Dice::class);
        /** @var IntegerObject|\Mockery\MockInterface $rolledNumber */
        $rolledNumber = \Mockery::mock(IntegerObject::class);
        /** @var IntegerObject $rollSequence */
        $rollSequence = \Mockery::mock(IntegerObject::class);
        $diceRoll = $diceRollBuilder->create($dice, $rolledNumber, $rollSequence);
        $this->assertInstanceOf(DiceRoll::class, $diceRoll);
        $this->assertSame($dice, $diceRoll->getDice());
        $this->assertSame($rolledNumber, $diceRoll->getRolledNumber());
        $rolledNumber->shouldReceive('getValue')
            ->andReturn($value = 'foo');
        /** @var \Mockery\MockInterface $diceRollEvaluator */
        $diceRollEvaluator = $diceRollBuilder->getDiceRollEvaluator();
        $diceRollEvaluator->shouldReceive('evaluateDiceRoll')
            ->with($diceRoll)
            ->once()
            ->andReturn($evaluatedValue = 'bar');
        $this->assertSame($evaluatedValue, $diceRoll->getEvaluatedValue());
        $this->assertSame($rollSequence, $diceRoll->getRollSequence());
        $this->assertSame($diceRollBuilder->getDiceRollEvaluator(), $diceRoll->getDiceRollEvaluator());
    }
}
