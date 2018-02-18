<?php
declare(strict_types=1);

namespace DrdPlus\Tests\DiceRolls\Templates\DiceRolls;

use DrdPlus\DiceRolls\Templates\DiceRolls\Dice1d6Roll;
use DrdPlus\DiceRolls\Templates\Dices\Dice1d6;
use DrdPlus\DiceRolls\Templates\Evaluators\OneToOneEvaluator;
use Granam\Integer\IntegerInterface;
use Granam\Integer\PositiveIntegerObject;
use Granam\Tests\Tools\TestWithMockery;

class Dice1d6RollTest extends TestWithMockery
{
    /**
     * @test
     */
    public function I_can_use_it()
    {
        $diceRoll = new Dice1d6Roll($rolledNumber = $this->createRolledNumber($rolledValue = \random_int(1, 6)), 1);
        self::assertSame(Dice1d6::getIt(), $diceRoll->getDice());
        self::assertSame($rolledNumber->getValue(), $diceRoll->getRolledNumber()->getValue());
        self::assertEquals(new PositiveIntegerObject(1), $diceRoll->getSequenceNumber());
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