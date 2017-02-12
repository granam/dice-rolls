<?php
namespace Drd\Tests\DiceRolls\Templates\Evaluators;

use Drd\DiceRolls\Templates\Evaluators\OneToOneEvaluator;

class OneToOneEvaluatorTest extends AbstractEvaluatorTest
{

    /**
     * @test
     */
    public function I_can_use_it_on_any_value_without_change()
    {
        $evaluator = OneToOneEvaluator::getIt();
        foreach (range(-10, 10, 1) as $value) {
            $evaluated = $evaluator->evaluateDiceRoll($this->createDiceRoll($value));
            self::assertSame($value, $evaluated->getValue());
        }
        self::assertEquals($evaluator, new OneToOneEvaluator(), 'OneToOne evaluator should be immutable');
    }
}