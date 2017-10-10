<?php
declare(strict_types=1);

namespace DrdPlus\Tests\DiceRolls\Templates\Evaluators;

use DrdPlus\DiceRolls\DiceRoll;
use DrdPlus\DiceRolls\DiceRollEvaluator;
use DrdPlus\DiceRolls\Templates\Evaluators\OneToOneEvaluator;
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
        self::assertSame($evaluator, $evaluatorClass::getIt());
        self::assertEquals($evaluator, new $evaluatorClass());
    }

    /**
     * @return string|DiceRollEvaluator|OneToOneEvaluator ...
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