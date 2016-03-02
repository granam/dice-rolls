<?php
namespace Drd\Tests\DiceRoll\Templates\Evaluators;

use Drd\DiceRoll\Templates\Evaluators\OneToOne;

class OneToOneTest extends AbstractEvaluatorTest
{

    /**
     * @test
     */
    public function I_can_use_it_on_any_value_without_change()
    {
        $evaluator = OneToOne::getIt();
        foreach (range(-10, 10, 1) as $value) {
            $evaluated = $evaluator->evaluateDiceRoll($this->createDiceRoll($value));
            $this->assertSame($value, $evaluated->getValue());
        }
        $this->assertEquals($evaluator, new OneToOne(), 'OneToOne evaluator should be immutable');
    }
}