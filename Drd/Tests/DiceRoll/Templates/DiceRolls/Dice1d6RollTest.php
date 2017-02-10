<?php
namespace Drd\Tests\DiceRoll\Templates\DiceRolls;

use Drd\DiceRoll\Templates\DiceRolls\Dice1d6Roll;
use Drd\DiceRoll\Templates\Dices\Dice1d6;
use Drd\DiceRoll\Templates\Evaluators\OneToOneEvaluator;
use Granam\Integer\IntegerInterface;
use Granam\Integer\IntegerObject;
use Granam\Tests\Tools\TestWithMockery;

class Dice1d6RollTest extends TestWithMockery
{
    /**
     * @test
     */
    public function I_can_use_it()
    {
        $diceRoll = new Dice1d6Roll(
            $dice1D6 = $this->create1d6Dice(),
            $rolledNumber = $this->createRolledNumber($rolledValue = 1234)
        );
        self::assertSame($dice1D6, $diceRoll->getDice());
        self::assertSame($rolledNumber, $diceRoll->getRolledNumber());
        self::assertEquals(new IntegerObject(1), $diceRoll->getSequenceNumber());
        self::assertSame(OneToOneEvaluator::getIt(), $diceRoll->getDiceRollEvaluator());
        self::assertSame($rolledValue, $diceRoll->getValue());
        self::assertSame((string)$rolledValue, (string)$diceRoll);
    }

    /**
     * @return \Mockery\MockInterface|Dice1d6
     */
    private function create1d6Dice()
    {
        return $this->mockery(Dice1d6::class);
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
}