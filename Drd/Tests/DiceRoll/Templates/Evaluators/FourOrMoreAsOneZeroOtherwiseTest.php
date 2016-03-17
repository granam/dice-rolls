<?php
namespace Drd\Tests\DiceRoll\Templates\Evaluators;

use Drd\DiceRoll\DiceRoll;
use Drd\DiceRoll\Templates\Evaluators\FourOrMoreAsOneZeroOtherwise;

class FourOrMoreAsOneZeroOtherwiseTest extends AbstractEvaluatorTest
{
    /**
     * @test
     */
    public function Greater_than_three_is_considered_as_one_otherwise_zero()
    {
        $evaluator = new FourOrMoreAsOneZeroOtherwise();
        /** @var DiceRoll|\Mockery\MockInterface $diceRoll */
        foreach (range(-4, 10, 1) as $value) {
            $evaluated = $evaluator->evaluateDiceRoll($this->createDiceRoll($value));
            if ($value > 3) {
                self::assertSame(
                    1,
                    $evaluated->getValue(),
                    "Value of $value should be 1, but was evaluated as {$evaluated->getValue()}"
                );
            } else {
                self::assertSame(0, $evaluated->getValue());
            }
        }
    }

}
