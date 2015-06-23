<?php
namespace Drd\DiceRoll\Templates\Evaluators;

use Drd\DiceRoll\DiceRoll;
use Granam\Integer\IntegerObject;

class SixOrMoreAsOneEvaluatorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function can_create_instance()
    {
        $instance = new SixOrMoreAsOneEvaluator();
        $this->assertNotNull($instance);
    }

    /**
     * @test
     * @depends can_create_instance
     */
    public function six_or_higher_value_is_considered_as_one()
    {
        $evaluator = new SixOrMoreAsOneEvaluator(\Mockery::mock(DiceRoll::class));
        /** @var DiceRoll|\Mockery\MockInterface $diceRoll */
        $diceRoll = \Mockery::mock(DiceRoll::class);
        $diceRoll->shouldReceive('getRolledNumber')
            ->once()
            ->andReturn($rolledNumber = \Mockery::mock(IntegerObject::class));
        $rolledNumber->shouldReceive('getValue')
            ->atLeast()->once()
            ->andReturnValues($values = [1,2,3,4,5,6,7,8,9,10]);
        foreach ($values as $value) {
            $evaluated = $evaluator->evaluateDiceRoll($diceRoll);
            if ($value < 6) {
                $this->assertSame(0, $evaluated->getValue());
            } else {
                $this->assertSame(1, $evaluated->getValue());
            }
        }
    }
}
