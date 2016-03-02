<?php
namespace Drd\Tests\DiceRoll;

use Drd\DiceRoll\DiceRollEvaluator;

class DiceRollEvaluatorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function I_can_use_dice_roll_evaluator_interface()
    {
        $this->assertTrue(interface_exists(DiceRollEvaluator::class));
        $reflection = new \ReflectionClass(DiceRollEvaluator::class);
        $methods = $reflection->getMethods();
        $this->assertCount(1, $methods);
        $this->assertTrue($reflection->hasMethod('evaluateDiceRoll'));
        $evaluateDiceRoll = new \ReflectionMethod(DiceRollEvaluator::class, 'evaluateDiceRoll');
        $this->assertSame(1, $evaluateDiceRoll->getNumberOfParameters());
        $this->assertSame(1, $evaluateDiceRoll->getNumberOfRequiredParameters());
        /** @var \ReflectionParameter $parameter */
        $parameter = current($evaluateDiceRoll->getParameters());
        $this->assertSame('diceRoll', $parameter->getName());
    }
}
