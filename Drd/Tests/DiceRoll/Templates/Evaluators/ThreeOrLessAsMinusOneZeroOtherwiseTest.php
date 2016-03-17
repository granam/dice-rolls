<?php
namespace Drd\Tests\DiceRoll\Templates\Evaluators;

use Drd\DiceRoll\Templates\Evaluators\ThreeOrLessAsMinusOneZeroOtherwise;

class ThreeOrLessAsMinusOneZeroOtherwiseTest extends AbstractEvaluatorTest
{

    /**
     * @test
     */
    public function Lesser_than_four_value_is_considered_as_minus_one_zero_otherwise()
    {
        $evaluator = ThreeOrLessAsMinusOneZeroOtherwise::getIt();
        foreach (range(-4, 10, 1) as $value) {
            $evaluated = $evaluator->evaluateDiceRoll($this->createDiceRoll($value));
            if ($value < 4) {
                self::assertSame(
                    -1,
                    $evaluated->getValue(),
                    "Value of $value should be -1, but was evaluated as {$evaluated->getValue()}"
                );
            } else {
                self::assertSame(0, $evaluated->getValue());
            }
        }
        self::assertEquals(
            $evaluator,
            new ThreeOrLessAsMinusOneZeroOtherwise(),
            'ThreeOrLessAsMinusOneZeroOtherwise should be immutable'
        );
    }

}
