<?php
namespace Drd\Tests\DiceRoll;

use Drd\DiceRoll\Dice;
use Drd\DiceRoll\DiceRoll;
use Drd\DiceRoll\DiceRollEvaluator;
use Drd\DiceRoll\Templates\Evaluators\OneToOne;
use Granam\Integer\IntegerInterface;
use Granam\Tests\Tools\TestWithMockery;

class DiceRollTest extends TestWithMockery
{
    /**
     * @test
     */
    public function I_can_use_it()
    {
        $diceRoll = new DiceRoll(
            $dice = $this->createDice(),
            $rolledNumber = $this->createRolledNumber($rolledValue = 1234),
            $sequenceNumber = $this->createRollSequence(),
            $diceRollEvaluator = $this->createDiceRollEvaluator()
        );
        $this->assertSame($dice, $diceRoll->getDice());
        $this->assertSame($rolledNumber, $diceRoll->getRolledNumber());
        $this->assertSame($sequenceNumber, $diceRoll->getSequenceNumber());
        $this->assertSame($diceRollEvaluator, $diceRoll->getDiceRollEvaluator());
        $this->assertSame($rolledValue, $diceRoll->getValue());
        $this->assertSame((string)$rolledValue, (string)$diceRoll);
    }

    /**
     * @return \Mockery\MockInterface|Dice
     */
    private function createDice()
    {
        return $this->mockery(Dice::class);
    }

    /**
     * @param int $rolledValue
     * @return \Mockery\MockInterface|IntegerInterface
     */
    private function createRolledNumber($rolledValue)
    {
        $rolledNumber = $this->mockery(IntegerInterface::class);
        $rolledNumber->shouldReceive('getValue')
            ->andReturn($rolledValue);

        return $rolledNumber;
    }

    /**
     * @return \Mockery\MockInterface|IntegerInterface
     */
    private function createRollSequence()
    {
        $rollSequence = $this->mockery(IntegerInterface::class);

        return $rollSequence;
    }

    /**
     * @return \Mockery\MockInterface|DiceRollEvaluator
     */
    private function createDiceRollEvaluator()
    {
        $evaluator = $this->mockery(OneToOne::class);
        $evaluator->makePartial();

        return $evaluator;
    }
}
