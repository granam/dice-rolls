<?php
namespace Drd\Tests\DiceRoll\Templates\Evaluators;

use Drd\DiceRoll\DiceRoll;
use Drd\DiceRoll\DiceRollEvaluator;
use Drd\DiceRoll\Templates\Evaluators\OneToOne;
use Granam\Integer\IntegerInterface;
use Granam\Tests\Tools\TestWithMockery;

abstract class AbstractEvaluatorTest extends TestWithMockery
{

    /**
     * @test
     */
    public function I_can_create_it()
    {
        $evaluatorClass = $this->getEvaluatorClass();
        $evaluator = $evaluatorClass::getIt();
        $this->assertSame($evaluator, $evaluatorClass::getIt());
        $this->assertEquals($evaluator, new $evaluatorClass());
    }

    /**
     * @return string|DiceRollEvaluator|OneToOne ...
     */
    protected function getEvaluatorClass()
    {
        return preg_replace('~[\\\]Tests([\\\].+)Test$~', '$1', static::class);
    }

    /**
     * @param $value
     * @return \Mockery\MockInterface|DiceRoll
     */
    protected function createDiceRoll($value)
    {
        $diceRoll = $this->mockery(DiceRoll::class);
        $diceRoll->shouldReceive('getRolledNumber')
            ->andReturn($rolledNumber = $this->mockery(IntegerInterface::class));
        $rolledNumber->shouldReceive('getValue')
            ->andReturn($value);

        return $diceRoll;
    }
}
