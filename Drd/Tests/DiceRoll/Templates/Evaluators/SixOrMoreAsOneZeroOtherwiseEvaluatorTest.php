<?php
namespace Drd\Tests\DiceRoll\Templates\Evaluators;

use Drd\DiceRoll\Templates\Evaluators\SixOrMoreAsOneZeroOtherwiseEvaluator;

class SixOrMoreAsOneZeroOtherwiseEvaluatorTest extends AbstractEvaluatorTest
{

    /**
     * @test
     */
    public function Six_or_higher_value_is_considered_as_one()
    {
        $evaluator = new SixOrMoreAsOneZeroOtherwiseEvaluator();
        foreach (range(-4, 10, 1) as $value) {
            $evaluated = $evaluator->evaluateDiceRoll($this->createDiceRoll($value));
            if ($value < 6) {
                self::assertSame(0, $evaluated->getValue());
            } else {
                self::assertSame(1, $evaluated->getValue());
            }
        }
    }
}