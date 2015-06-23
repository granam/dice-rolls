<?php
namespace Drd\DiceRoll\Templates\Evaluators;

use Drd\DiceRoll\DiceRoll;
use Granam\Integer\IntegerObject;

class OneToOneEvaluatorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function can_create_instance()
    {
        $instance = new OneToOneEvaluator();
        $this->assertNotNull($instance);
    }

    /**
     * @test
     * @depends can_create_instance
     */
    public function any_value_remains_untouched()
    {
        $evaluator = new OneToOneEvaluator(\Mockery::mock(DiceRoll::class));
        /** @var DiceRoll|\Mockery\MockInterface $diceRoll */
        $diceRoll = \Mockery::mock(DiceRoll::class);
        $diceRoll->shouldReceive('getRolledNumber')
            ->once()
            ->andReturn($rolledNumber = \Mockery::mock(IntegerObject::class));
        $rolledNumber->shouldReceive('getValue')
            ->atLeast()->once()
            ->andReturnValues($values = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
        foreach ($values as $value) {
            $evaluated = $evaluator->evaluateDiceRoll($diceRoll);
            $this->assertSame($value, $evaluated->getValue());
        }
    }
}
