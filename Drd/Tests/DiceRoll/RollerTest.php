<?php
namespace Drd\Tests\DiceRoll;

use Drd\DiceRoll\Dice;
use Drd\DiceRoll\DiceRoll;
use Drd\DiceRoll\DiceRollEvaluator;
use Drd\DiceRoll\Roller;
use Drd\DiceRoll\RollOn;
use Granam\Integer\IntegerInterface;
use Granam\Tests\Tools\TestWithMockery;

class RollerTest extends TestWithMockery
{

    /**
     * @test
     */
    public function I_can_create_it()
    {
        $rollerWithMalus = new Roller(
            $dice = $this->createDice(),
            $numberOfStandardRolls = $this->createNumberOfStandardRolls(),
            $diceRollEvaluator = $this->createDiceRollEvaluator(),
            $bonusRollOn = $this->createBonusRollOn(),
            $malusRollOn = $this->createMalusRollOn()
        );
        $this->assertSame($dice, $rollerWithMalus->getDice());
        $this->assertSame($numberOfStandardRolls, $rollerWithMalus->getNumberOfStandardRolls());
        $this->assertSame($diceRollEvaluator, $rollerWithMalus->getDiceRollEvaluator());
        $this->assertSame($bonusRollOn, $rollerWithMalus->getBonusRollOn());
        $this->assertSame($malusRollOn, $rollerWithMalus->getMalusRollOn());
    }

    /**
     * @param int $minimumValue
     * @param int $maximumValue
     * @return \Mockery\MockInterface|Dice
     */
    private function createDice($minimumValue = 1, $maximumValue = 1)
    {
        $dice = $this->mockery(Dice::class);
        $dice->shouldReceive('getMinimum')
            ->andReturn($minimum = $this->mockery(IntegerInterface::class));
        $minimum->shouldReceive('getValue')
            ->andReturn($minimumValue);
        $dice->shouldReceive('getMaximum')
            ->andReturn($maximum = $this->mockery(IntegerInterface::class));
        $maximum->shouldReceive('getValue')
            ->andReturn($maximumValue);

        return $dice;
    }

    /**
     * @param int $number
     * @return \Mockery\MockInterface|IntegerInterface
     */
    private function createNumberOfStandardRolls($number = 1)
    {
        $numberOfStandardRolls = $this->mockery(IntegerInterface::class);
        $numberOfStandardRolls->shouldReceive('getValue')
            ->andReturn($number);

        return $numberOfStandardRolls;
    }

    /**
     * @return \Mockery\MockInterface|DiceRollEvaluator
     */
    private function createDiceRollEvaluator()
    {
        $diceRollEvaluator = $this->mockery(DiceRollEvaluator::class);
        $diceRollEvaluator->shouldReceive('evaluateDiceRoll')
            ->with(\Mockery::type(DiceRoll::class))
            ->andReturnUsing(function (DiceRoll $diceRoll) {
                return $diceRoll->getRolledNumber(); // de facto one to one
            });

        return $diceRollEvaluator;
    }

    /**
     * @param array|int $shouldHappenOn
     * @param array|DiceRoll[] $diceRolls
     * @return RollOn|\Mockery\MockInterface
     */
    private function createBonusRollOn($shouldHappenOn = [], $diceRolls = [])
    {
        return $this->createRollOn($shouldHappenOn, $diceRolls);
    }

    /**
     * @param array|int[] $shouldHappenOn
     * @param array|DiceRoll[] $diceRolls
     * @return \Mockery\MockInterface|RollOn
     */
    private function createRollOn($shouldHappenOn, array $diceRolls)
    {
        $rollOn = $this->mockery(RollOn::class);
        $rollOn->shouldReceive('shouldHappen')
            ->andReturnUsing(function ($value) use ($shouldHappenOn) {
                return in_array($value, $shouldHappenOn);
            });
        $rollOn->shouldReceive('rollDices')
            ->andReturn($diceRolls);

        return $rollOn;
    }

    /**
     * @param array $shouldHappenOn
     * @param array|DiceRoll[] $diceRolls
     * @return RollOn|\Mockery\MockInterface
     */
    private function createMalusRollOn(array $shouldHappenOn = [], array $diceRolls = [])
    {
        return $this->createRollOn($shouldHappenOn, $diceRolls);
    }

    /**
     * @test
     * @expectedException \Drd\DiceRoll\Exceptions\InvalidDiceRange
     */
    public function I_can_not_use_strange_dice_with_minimum_greater_than_maximum()
    {
        new Roller(
            $this->createDice(2, 1),
            $this->createNumberOfStandardRolls(),
            $this->createDiceRollEvaluator(),
            $this->createBonusRollOn(),
            $this->createMalusRollOn()
        );
    }

    /**
     * @test
     * @expectedException \Drd\DiceRoll\Exceptions\InvalidNumberOfRolls
     */
    public function I_can_not_use_zero_number_of_standard_rolls()
    {
        new Roller(
            $this->createDice(),
            $this->createNumberOfStandardRolls(0),
            $this->createDiceRollEvaluator(),
            $this->createBonusRollOn(),
            $this->createMalusRollOn()
        );
    }

    /**
     * @test
     * @expectedException \Drd\DiceRoll\Exceptions\InvalidNumberOfRolls
     */
    public function I_can_not_use_negative_number_of_standard_rolls()
    {
        new Roller(
            $this->createDice(),
            $this->createNumberOfStandardRolls(-1),
            $this->createDiceRollEvaluator(),
            $this->createBonusRollOn(),
            $this->createMalusRollOn()
        );
    }

    /**
     * @test
     * @expectedException \Drd\DiceRoll\Exceptions\BonusAndMalusChanceConflict
     */
    public function I_can_not_use_bonus_and_malus_with_same_triggering_values()
    {
        new Roller(
            $this->createDice(1, 5),
            $this->createNumberOfStandardRolls(),
            $this->createDiceRollEvaluator(),
            $this->createBonusRollOn([2, 3]),
            $this->createMalusRollOn([3, 4])
        );
    }

    /**
     * @test
     */
    public function I_can_roll()
    {
        $roller = new Roller(
            $dice = $this->createDice($minimumValue = 111, $maximumValue = 222),
            $this->createNumberOfStandardRolls($numberOfRollsValue = 5),
            $this->createDiceRollEvaluator(),
            $bonusRollOn = $this->createBonusRollOn(),
            $malusRollOn = $this->createMalusRollOn()
        );
        $roll = $roller->roll();
        $this->assertGreaterThanOrEqual($minimumValue * $numberOfRollsValue, $roll->getValue());
        $this->assertLessThanOrEqual($maximumValue * $numberOfRollsValue, $roll->getValue());

        $summary = 0;
        $currentRollSequence = 0;
        foreach ($roll->getDiceRolls() as $diceRoll) {
            $currentRollSequence++;
            $this->assertSame($dice, $diceRoll->getDice());
            $summary += $diceRoll->getRolledNumber()->getValue();
            $this->assertSame(
                $currentRollSequence,
                $diceRoll->getRollSequence()->getValue() /* integer from the mock */,
                'Roll sequence is not successive'
            );
        }
        $this->assertSame($currentRollSequence, $numberOfRollsValue);
        $this->assertSame($roll->getValue(), $summary);
        $this->assertSame($roll->getDiceRolls(), $roll->getStandardDiceRolls());
        $this->assertEquals([], $roll->getBonusDiceRolls());
        $this->assertEquals([], $roll->getMalusDiceRolls());
    }

    /**
     * @test
     */
    public function I_can_roll_with_bonus()
    {
        $roller = new Roller(
            $dice = $this->createDice($minimumValue = 5, $maximumValue = 13),
            $numberOfRolls = $this->createNumberOfStandardRolls(),
            $diceRollEvaluator = $this->createDiceRollEvaluator(),
            $bonusRollOn = $this->createBonusRollOn([7], [$bonusDiceRoll = $this->createDiceRoll()]),
            $malusRollOn = $this->createMalusRollOn()
        );
        $bonusCount = 0;
        for ($attempt = 1; $attempt < 1000; $attempt++) {
            $roll = $roller->roll();
            foreach ($roll->getDiceRolls() as $diceRoll) {
                if ($diceRoll === $bonusDiceRoll) {
                    $bonusCount++;
                }
            }
            if ($bonusCount > 1) { // at least twice
                break;
            }
        }
        $this->assertGreaterThan(0, $bonusCount);
    }

    /**
     * @return \Mockery\MockInterface|DiceRoll
     */
    private function createDiceRoll()
    {
        $diceRoll = $this->mockery(DiceRoll::class);

        return $diceRoll;
    }

    /**
     * @test
     */
    public function I_can_roll_with_malus()
    {
        $roller = new Roller(
            $dice = $this->createDice($minimumValue = 5, $maximumValue = 13),
            $numberOfRolls = $this->createNumberOfStandardRolls(),
            $diceRollEvaluator = $this->createDiceRollEvaluator(),
            $bonusRollOn = $this->createBonusRollOn(),
            $malusRollOn = $this->createMalusRollOn(
                [6, 7, 11],
                [$malusDiceRoll1 = $this->createDiceRoll(), $malusDiceRoll2 = $this->createDiceRoll()]
            )
        );
        $malusCount = 0;
        for ($attempt = 1; $attempt < 1000; $attempt++) {
            $roll = $roller->roll();
            foreach ($roll->getDiceRolls() as $diceRoll) {
                if (in_array($diceRoll, [$malusDiceRoll1, $malusDiceRoll2])) {
                    $malusCount++;
                }
            }
            if ($malusCount > 1) { // at least twice
                break;
            }
        }
        $this->assertGreaterThan(0, $malusCount);
    }

}
