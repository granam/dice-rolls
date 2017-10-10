<?php
declare(strict_types=1);

namespace DrdPlus\Tests\DiceRolls\Templates\DiceRolls;

use DrdPlus\DiceRolls\Templates\DiceRolls\Dice1d6Roll;
use DrdPlus\DiceRolls\Templates\Dices\Dice1d6;
use DrdPlus\DiceRolls\Templates\Evaluators\OneToOneEvaluator;
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
        $diceRoll = new Dice1d6Roll($rolledNumber = $this->createRolledNumber($rolledValue = 1234));
        self::assertSame(Dice1d6::getIt(), $diceRoll->getDice());
        self::assertSame($rolledNumber, $diceRoll->getRolledNumber());
        self::assertEquals(new IntegerObject(1), $diceRoll->getSequenceNumber());
        self::assertSame(OneToOneEvaluator::getIt(), $diceRoll->getDiceRollEvaluator());
        self::assertSame($rolledValue, $diceRoll->getValue());
        self::assertSame((string)$rolledValue, (string)$diceRoll);
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