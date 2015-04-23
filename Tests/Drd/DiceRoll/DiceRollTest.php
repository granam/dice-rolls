<?php
namespace Drd\DiceRoll;

use Granam\Strict\Integer\StrictInteger;

class DiceRollTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function can_create_instance()
    {
        /** @var Dice $dice */
        $dice = \Mockery::mock(Dice::class);
        /** @var StrictInteger $rolledValue */
        $rolledValue = \Mockery::mock(StrictInteger::class);
        /** @var $diceRollEvaluator DiceRollEvaluatorInterface */
        $diceRollEvaluator = \Mockery::mock(DiceRollEvaluatorInterface::class);
        /** @var StrictInteger $rollSequence */
        $rollSequence = \Mockery::mock(StrictInteger::class);
        $instance = new DiceRoll($dice, $rolledValue, $diceRollEvaluator, $rollSequence);
        $this->assertInstanceOf(DiceRoll::class, $instance);
        $this->assertSame($dice, $instance->getDice());
        $this->assertSame($rolledValue, $instance->getRolledValue());
        $this->assertSame($rollSequence, $instance->getRollSequence());
    }
}
