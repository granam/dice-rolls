<?php
namespace Drd\Tests\DiceRoll\Templates\Rolls;

use Drd\DiceRoll\Dice;
use Drd\DiceRoll\DiceRoll;
use Drd\DiceRoll\Templates\Dices\Dice1d6;
use Drd\DiceRoll\Templates\Rolls\Roll1d6;
use Granam\Integer\PositiveInteger;
use Granam\Tests\Tools\TestWithMockery;

class Roll1d6Test extends TestWithMockery
{
    /**
     * @test
     */
    public function I_can_use_it()
    {
        $roll1d6 = new Roll1d6($diceRoll = $this->createDiceRoll($this->mockery(Dice1d6::class)));
        self::assertInstanceOf(PositiveInteger::class, $roll1d6);
        self::assertSame($diceRoll, $roll1d6->getDiceRoll());
        self::assertSame([$diceRoll], $roll1d6->getDiceRolls());
        self::assertSame([$diceRoll], $roll1d6->getStandardDiceRolls());
        self::assertSame([], $roll1d6->getBonusDiceRolls());
        self::assertSame([], $roll1d6->getMalusDiceRolls());
    }

    /**
     * @param \Mockery\MockInterface|Dice $dice
     * @return \Mockery\MockInterface|DiceRoll
     */
    private function createDiceRoll(\Mockery\MockInterface $dice)
    {
        $d = $this->mockery(DiceRoll::class);
        $d->shouldReceive('getDice')
            ->andReturn($dice);

        return $d;
    }

    /**
     * @test
     * @expectedException \Drd\DiceRoll\Templates\Rolls\Exceptions\UnexpectedDice
     */
    public function I_can_not_create_it_with_roll_of_different_dice_than_1d6()
    {
        new Roll1d6($this->createDiceRoll($this->mockery(Dice::class)));
    }
}