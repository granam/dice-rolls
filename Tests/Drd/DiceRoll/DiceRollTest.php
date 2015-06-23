<?php
namespace Drd\DiceRoll;

use Granam\Integer\IntegerObject;

class DiceRollTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function can_create_instance()
    {
        /** @var Dice $dice */
        $dice = \Mockery::mock(Dice::class);
        /** @var IntegerObject $rolledValue */
        $rolledValue = \Mockery::mock(IntegerObject::class);
        /** @var $diceRollEvaluator DiceRollEvaluatorInterface */
        $diceRollEvaluator = \Mockery::mock(DiceRollEvaluatorInterface::class);
        /** @var IntegerObject $rollSequence */
        $rollSequence = \Mockery::mock(IntegerObject::class);
        $instance = new DiceRoll($dice, $rolledValue, $diceRollEvaluator, $rollSequence);
        $this->assertInstanceOf(DiceRoll::class, $instance);
        $this->assertSame($dice, $instance->getDice());
        $this->assertSame($rolledValue, $instance->getRolledNumber());
        $this->assertSame($rollSequence, $instance->getRollSequence());
    }
}
