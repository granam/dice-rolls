<?php
declare(strict_types=1);

namespace DrdPlus\Tests\DiceRolls\Templates\DiceRolls;

use DrdPlus\DiceRolls\DiceRoll;
use DrdPlus\DiceRolls\DiceRollEvaluator;
use DrdPlus\DiceRolls\Templates\Dices\Dice1d6;
use Granam\Integer\IntegerInterface;
use Granam\Integer\PositiveIntegerObject;
use Granam\Tests\Tools\TestWithMockery;

abstract class AbstractDice1d6RollTest extends TestWithMockery
{
    /**
     * @test
     */
    public function I_can_use_it()
    {
        $sutClass = self::getSutClass();
        /** @var DiceRoll $diceRoll */
        $diceRoll = new $sutClass($rolledNumber = $this->createRolledNumber($rolledValue = \random_int(1, 6)), 1);
        self::assertSame(Dice1d6::getIt(), $diceRoll->getDice());
        self::assertSame($rolledNumber->getValue(), $diceRoll->getRolledNumber()->getValue());
        self::assertEquals(new PositiveIntegerObject(1), $diceRoll->getSequenceNumber());
        self::assertSame($this->getDiceRollEvaluator(), $diceRoll->getDiceRollEvaluator());
        self::assertSame($this->getDiceRollEvaluator()->evaluateDiceRoll($diceRoll)->getValue(), $diceRoll->getValue());
        self::assertSame((string)$rolledValue, (string)$diceRoll->getRolledNumber());
    }

    abstract protected function getDiceRollEvaluator(): DiceRollEvaluator;

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