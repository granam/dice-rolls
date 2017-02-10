<?php
namespace Drd\Tests\DiceRoll;

use Drd\DiceRoll\Dice;
use Drd\DiceRoll\DiceRoll;
use Drd\DiceRoll\DiceRollEvaluator;
use Drd\DiceRoll\Templates\Evaluators\OneToOneEvaluator;
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
        self::assertSame($dice, $diceRoll->getDice());
        self::assertSame($rolledNumber, $diceRoll->getRolledNumber());
        self::assertSame($sequenceNumber, $diceRoll->getSequenceNumber());
        self::assertSame($diceRollEvaluator, $diceRoll->getDiceRollEvaluator());
        self::assertSame($rolledValue, $diceRoll->getValue());
        self::assertSame((string)$rolledValue, (string)$diceRoll);
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
        return $this->mockery(IntegerInterface::class);
    }

    /**
     * @return \Mockery\MockInterface|DiceRollEvaluator
     */
    private function createDiceRollEvaluator()
    {
        $evaluator = $this->mockery(OneToOneEvaluator::class);
        $evaluator->makePartial();

        return $evaluator;
    }
}
