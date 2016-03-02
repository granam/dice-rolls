<?php
namespace Drd\Tests\DiceRoll;

use Drd\DiceRoll\DiceRoll;
use Drd\DiceRoll\Roll;
use Granam\Integer\IntegerInterface;
use Granam\Tests\Tools\TestWithMockery;

class RollTest extends TestWithMockery
{
    /**
     * @test
     */
    public function I_can_create_it_without_bonus_and_malus_rolls()
    {
        $roll = new Roll($diceRolls = $this->createDiceRolls($values = [1, 2, 3]));
        $rolledNumbers = $roll->getRolledNumbers();
        $this->assertCount(count($values), $rolledNumbers);
        foreach ($rolledNumbers as $index => $rolledNumber) {
            $this->assertInstanceOf(IntegerInterface::class, $rolledNumber);
            $this->assertSame($values[$index], $rolledNumber->getValue());
        }
        $this->assertSame(array_sum($values), $roll->getValue());
        $this->assertSame((string)array_sum($values), (string)$roll);
        $this->assertSame($diceRolls, $roll->getDiceRolls());
        $this->assertEquals($diceRolls, $roll->getStandardDiceRolls());
        $this->assertEquals([], $roll->getBonusDiceRolls());
        $this->assertEquals([], $roll->getMalusDiceRolls());
    }

    private function createDiceRolls(array $values)
    {
        $diceRolls = [];
        foreach ($values as $value) {
            $diceRoll = $this->mockery(DiceRoll::class);
            $diceRoll->shouldReceive('getRolledNumber')
                ->andReturn($rolledNumber = $this->mockery(IntegerInterface::class));
            $rolledNumber->shouldReceive('getValue')
                ->andReturn($value);
            $diceRoll->shouldReceive('getValue')
                ->andReturn($value); // assuming 1 to 1 evaluator
            $diceRolls[] = $diceRoll;
        }

        return $diceRolls;
    }

    /**
     * @test
     */
    public function I_can_create_it_with_bonus_but_without_malus_rolls()
    {
        $roll = new Roll(
            $standardDiceRolls = $this->createDiceRolls($standardValues = [1, 2, 3]),
            $bonusDiceRolls = $this->createDiceRolls($bonusValues = [11, 13, 17, 19])
        );
        $rolledNumbers = $roll->getRolledNumbers();
        $values = array_merge($standardValues, $bonusValues);
        $this->assertCount(count($values), $rolledNumbers);
        foreach ($rolledNumbers as $index => $rolledNumber) {
            $this->assertInstanceOf(IntegerInterface::class, $rolledNumber);
            $this->assertSame($values[$index], $rolledNumber->getValue());
        }
        $this->assertSame(array_sum($values), $roll->getValue());
        $this->assertSame((string)array_sum($values), (string)$roll);
        $this->assertEquals(array_merge($standardDiceRolls, $bonusDiceRolls), $roll->getDiceRolls());
        $this->assertEquals($standardDiceRolls, $roll->getStandardDiceRolls());
        $this->assertEquals($bonusDiceRolls, $roll->getBonusDiceRolls());
        $this->assertEquals([], $roll->getMalusDiceRolls());
    }

    /**
     * @test
     */
    public function I_can_create_it_without_bonus_but_with_malus_rolls()
    {
        $roll = new Roll(
            $standardDiceRolls = $this->createDiceRolls($standardValues = [1, 2, 3]),
            [],
            $malusDiceRolls = $this->createDiceRolls($malusValues = [5, 11])
        );
        $rolledNumbers = $roll->getRolledNumbers();
        $values = array_merge($standardValues, $malusValues);
        $this->assertCount(count($values), $rolledNumbers);
        foreach ($rolledNumbers as $index => $rolledNumber) {
            $this->assertInstanceOf(IntegerInterface::class, $rolledNumber);
            $this->assertSame($values[$index], $rolledNumber->getValue());
        }
        $this->assertSame(array_sum($values), $roll->getValue());
        $this->assertSame((string)array_sum($values), (string)$roll);
        $this->assertEquals(array_merge($standardDiceRolls, $malusDiceRolls), $roll->getDiceRolls());
        $this->assertEquals($standardDiceRolls, $roll->getStandardDiceRolls());
        $this->assertEquals([], $roll->getBonusDiceRolls());
        $this->assertEquals($malusDiceRolls, $roll->getMalusDiceRolls());
    }

    /**
     * @test
     */
    public function I_can_create_it_with_bonus_and_malus_rolls()
    {
        $roll = new Roll(
            $standardDiceRolls = $this->createDiceRolls($standardValues = [1, 2, 3]),
            $bonusDiceRolls = $this->createDiceRolls($bonusValues = [11, 13, 17, 19]),
            $malusDiceRolls = $this->createDiceRolls($malusValues = [5, 6])
        );
        $rolledNumbers = $roll->getRolledNumbers();
        $values = array_merge($standardValues, $bonusValues, $malusValues);
        $this->assertCount(count($values), $rolledNumbers);
        foreach ($rolledNumbers as $index => $rolledNumber) {
            $this->assertInstanceOf(IntegerInterface::class, $rolledNumber);
            $this->assertSame($values[$index], $rolledNumber->getValue());
        }
        $this->assertSame(array_sum($values), $roll->getValue());
        $this->assertSame((string)array_sum($values), (string)$roll);
        $this->assertEquals(array_merge($standardDiceRolls, $bonusDiceRolls, $malusDiceRolls), $roll->getDiceRolls());
        $this->assertEquals($standardDiceRolls, $roll->getStandardDiceRolls());
        $this->assertEquals($bonusDiceRolls, $roll->getBonusDiceRolls());
        $this->assertEquals($malusDiceRolls, $roll->getMalusDiceRolls());
    }
}