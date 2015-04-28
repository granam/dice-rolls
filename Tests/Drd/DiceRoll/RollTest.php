<?php
namespace Drd\DiceRoll;

use Granam\Strict\Integer\StrictInteger;

class RollTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function can_create_instance()
    {
        /** @var Dice|\Mockery\MockInterface $dice */
        $dice = \Mockery::mock(Dice::class);
        $dice->shouldReceive('getMinimum')
            ->andReturn($diceMinimum = \Mockery::mock(StrictInteger::class));
        $diceMinimum->shouldReceive('getValue')
            ->andReturn(1);
        $dice->shouldReceive('getMaximum')
            ->andReturn($diceMaximum = \Mockery::mock(StrictInteger::class));
        $diceMaximum->shouldReceive('getValue')
            ->andReturn(2);
        /** @var StrictInteger|\Mockery\MockInterface $numberOfRolls */
        $numberOfRolls = \Mockery::mock(StrictInteger::class);
        $numberOfRolls->shouldReceive('getValue')
            ->andReturn(1);/* count of rolls, if no bonus happens */
        /** @var DiceRollBuilder $diceRollBuilder */
        $diceRollBuilder = \Mockery::mock(DiceRollBuilder::class);
        /** @var RollOnInterface|\Mockery\MockInterface $bonusRollOn */
        $bonusRollOn = \Mockery::mock(RollOnInterface::class);
        $bonusRollOn->shouldReceive('shouldHappen')
            ->andReturn(false);
        /** @var RollOnInterface|\Mockery\MockInterface $malusRollOn */
        $malusRollOn = \Mockery::mock(RollOnInterface::class);
        $malusRollOn->shouldReceive('shouldHappen')
            ->andReturn(false);
        $instance = new Roll($dice, $numberOfRolls, $diceRollBuilder, $bonusRollOn, $malusRollOn);
        $this->assertInstanceOf(Roll::class, $instance);
        $this->assertSame($dice, $instance->getDice());

        return $instance;
    }

    /**
     * @test
     * @depends can_create_instance
     * @expectedException \LogicException
     */
    public function zero_roll_count_cause_exception()
    {
        /** @var Dice|\Mockery\MockInterface $dice */
        $dice = \Mockery::mock(Dice::class);
        $dice->shouldReceive('getMinimum')
            ->andReturn($minimum = \Mockery::mock(StrictInteger::class));
        $minimum->shouldReceive('getValue')
            ->andReturn($minimumValue = 12345);
        $dice->shouldReceive('getMaximum')
            ->andReturn($maximum = \Mockery::mock(StrictInteger::class));
        $maximum->shouldReceive('getValue')
            ->andReturn(98765);
        /** @var StrictInteger|\Mockery\MockInterface $numberOfRolls */
        $numberOfRolls = \Mockery::mock(StrictInteger::class);
        $numberOfRolls->shouldReceive('getValue')
            ->andReturn(0 /* no roll at all */);
        /** @var DiceRollBuilder $diceRollBuilder */
        $diceRollBuilder = \Mockery::mock(DiceRollBuilder::class);
        /** @var RollOnInterface|\Mockery\MockInterface $bonusRollOn */
        $bonusRollOn = \Mockery::mock(RollOnInterface::class);
        /** @var RollOnInterface|\Mockery\MockInterface $malusRollOn */
        $malusRollOn = \Mockery::mock(RollOnInterface::class);
        $malusRollOn->shouldReceive('shouldHappen');
        new Roll($dice, $numberOfRolls, $diceRollBuilder, $bonusRollOn, $malusRollOn);
    }

    /**
     * @test
     * @depends zero_roll_count_cause_exception
     * @expectedException \LogicException
     */
    public function higher_minimal_then_maximal_roll_cause_exception()
    {
        /** @var Dice|\Mockery\MockInterface $dice */
        $dice = \Mockery::mock(Dice::class);
        $dice->shouldReceive('getMinimum')
            ->andReturn($minimum = \Mockery::mock(StrictInteger::class));
        $minimum->shouldReceive('getValue')
            ->andReturn($minimumValue = 12345);
        $dice->shouldReceive('getMaximum')
            ->andReturn($maximum = \Mockery::mock(StrictInteger::class));
        $maximum->shouldReceive('getValue')
            ->andReturn($minimumValue - 1);
        /** @var StrictInteger|\Mockery\MockInterface $numberOfRolls */
        $numberOfRolls = \Mockery::mock(StrictInteger::class);
        $numberOfRolls->shouldReceive('getValue')
            ->andReturn(1);
        /** @var DiceRollBuilder $diceRollBuilder */
        $diceRollBuilder = \Mockery::mock(DiceRollBuilder::class);
        /** @var RollOnInterface|\Mockery\MockInterface $bonusRollOn */
        $bonusRollOn = \Mockery::mock(RollOnInterface::class);
        /** @var RollOnInterface|\Mockery\MockInterface $malusRollOn */
        $malusRollOn = \Mockery::mock(RollOnInterface::class);
        $malusRollOn->shouldReceive('shouldHappen');
        new Roll($dice, $numberOfRolls, $diceRollBuilder, $bonusRollOn, $malusRollOn);
    }

    /**
     * @test
     * @depends can_create_instance
     */
    public function last_roll_is_kept_only()
    {
        /** @var Dice|\Mockery\MockInterface $dice */
        $dice = \Mockery::mock(Dice::class);
        /** @var StrictInteger|\Mockery\MockInterface $minimum */
        $dice->shouldReceive('getMinimum')
            ->andReturn($minimum = \Mockery::mock(StrictInteger::class));
        $minimum->shouldReceive('getValue')
            ->andReturn($minimumValue = 1);
        /** @var StrictInteger|\Mockery\MockInterface $maximum */
        $dice->shouldReceive('getMaximum')
            ->andReturn($maximum = \Mockery::mock(StrictInteger::class));
        $maximum->shouldReceive('getValue')
            ->andReturn(6);
        /** @var StrictInteger|\Mockery\MockInterface $numberOfRolls */
        $numberOfRolls = \Mockery::mock(StrictInteger::class);
        $numberOfRolls->shouldReceive('getValue')
            ->andReturn(1 /* single roll */);
        /** @var DiceRollBuilder|\Mockery\MockInterface $diceRollBuilder */
        $diceRollBuilder = \Mockery::mock(DiceRollBuilder::class);
        $createDiceRollParams = false;
        $diceRoll = \Mockery::mock(DiceRoll::class);
        $diceRollBuilder->shouldReceive('create')
            ->andReturnUsing(function () use (&$createDiceRollParams, $diceRoll) {
                $createDiceRollParams = func_get_args();
                return $diceRoll;
            });
        $diceRoll->shouldReceive('getRolledValue')
            ->andReturn($diceRollValue = \Mockery::mock(StrictInteger::class));
        $diceRollValue->shouldReceive('getValue')
            ->andReturn($diceRollIntValue = 5);
        /** @var RollOnInterface|\Mockery\MockInterface $bonusRollOn */
        $bonusRollOn = \Mockery::mock(RollOnInterface::class);
        $bonusRollOn->shouldReceive('shouldHappen')
            ->andReturn(false);
        $bonusRollOn->shouldReceive('getLastRollSummary')
            ->andReturn(0);
        /** @var RollOnInterface|\Mockery\MockInterface $malusRollOn */
        $malusRollOn = \Mockery::mock(RollOnInterface::class);
        $malusRollOn->shouldReceive('shouldHappen')
            ->andReturn(false);
        $malusRollOn->shouldReceive('getLastRollSummary')
            ->andReturn(0);
        $roll = new Roll($dice, $numberOfRolls, $diceRollBuilder, $bonusRollOn, $malusRollOn);
        $summary = 0;
        for ($cycle = 1; $cycle < 10; $cycle++) {
            $summary += $value = $roll->roll();
            $this->assertSame($dice, $createDiceRollParams[0]);
            $this->assertInstanceOf(StrictInteger::class, $createDiceRollParams[1]);
            $this->assertInstanceOf(StrictInteger::class, $currentRollSequence = $createDiceRollParams[2]);
            /** @var StrictInteger $currentRollSequence */
            $this->assertSame(1, $currentRollSequence->getValue());
            $this->assertGreaterThanOrEqual($minimum->getValue(), $value);
            $this->assertLessThanOrEqual($maximum->getValue(), $value);
            $this->assertLessThanOrEqual($summary, $value);
            $this->assertLessThanOrEqual($value, $roll->getLastRollSummary());
        }
        $this->assertLessThanOrEqual($maximum->getValue(), $roll->getLastRollSummary());
        $this->assertSame(1, count($roll->getLastDiceRolls()));
        $this->assertSame(1, count($roll->getLastRolledNumbers()));
    }

    /**
     * @test
     * @depends can_create_instance
     */
    public function gives_same_values_as_got()
    {
        /** @var Dice|\Mockery\MockInterface $dice */
        $dice = \Mockery::mock(Dice::class);
        $dice->shouldReceive('getMinimum')
            ->andReturn($minimum = \Mockery::mock(StrictInteger::class));
        $minimum->shouldReceive('getValue')
            ->andReturn($minimumValue = 123);
        $dice->shouldReceive('getMaximum')
            ->andReturn($maximum = \Mockery::mock(StrictInteger::class));
        $maximum->shouldReceive('getValue')
            ->andReturn(1234);
        /** @var StrictInteger|\Mockery\MockInterface $numberOfRolls */
        $numberOfRolls = \Mockery::mock(StrictInteger::class);
        $numberOfRolls->shouldReceive('getValue')
            ->andReturn(123);
        /** @var DiceRollBuilder $diceRollBuilder */
        $diceRollBuilder = \Mockery::mock(DiceRollBuilder::class);
        /** @var RollOnInterface|\Mockery\MockInterface $bonusRollOn */
        $bonusRollOn = \Mockery::mock(RollOnInterface::class);
        $bonusRollOn->shouldReceive('shouldHappen')
            ->andReturn(false);
        /** @var RollOnInterface|\Mockery\MockInterface $malusRollOn */
        $malusRollOn = \Mockery::mock(RollOnInterface::class);
        $malusRollOn->shouldReceive('shouldHappen')
            ->andReturn(false);
        $roll = new Roll($dice, $numberOfRolls, $diceRollBuilder, $bonusRollOn, $malusRollOn);
        $this->assertSame($dice, $roll->getDice());
        $this->assertSame($numberOfRolls, $roll->getNumberOfRolls());
        $this->assertSame($bonusRollOn, $roll->getBonusRollOn());
        $this->assertSame($malusRollOn, $roll->getMalusRollOn());
    }

    /**
     * @param Roll $roll
     *
     * @test
     * @depends can_create_instance
     */
    public function last_roll_is_empty_before_any_roll(Roll $roll)
    {
        $this->assertSame([], $roll->getLastDiceRolls());
    }

    /**
     * @param Roll $roll
     *
     * @test
     * @depends can_create_instance
     */
    public function last_roll_numbers_are_empty_before_any_roll(Roll $roll)
    {
        $this->assertSame([], $roll->getLastRolledNumbers());
    }

    /**
     * @param Roll $roll
     *
     * @test
     * @depends can_create_instance
     */
    public function roll_summary_is_zero_before_any_roll(Roll $roll)
    {
        /** @var RollOnInterface|\Mockery\MockInterface $bonusRollOn */
        $bonusRollOn = $roll->getBonusRollOn();
        $bonusRollOn->shouldReceive('getLastRollSummary')
            ->andReturn(0);
        /** @var RollOnInterface|\Mockery\MockInterface $malusRollOn */
        $malusRollOn = $roll->getMalusRollOn();
        $malusRollOn->shouldReceive('getLastRollSummary')
            ->andReturn(0);
        $this->assertSame(0, $roll->getLastRollSummary());
    }

    /**
     * @test
     * @depends can_create_instance
     */
    public function can_roll()
    {
        /** @var Dice|\Mockery\MockInterface $dice */
        $dice = \Mockery::mock(Dice::class);
        $dice->shouldReceive('getMinimum')
            ->andReturn($minimum = \Mockery::mock(StrictInteger::class));
        $minimum->shouldReceive('getValue')
            ->andReturn($minimumValue = 111);
        $dice->shouldReceive('getMaximum')
            ->andReturn($maximum = \Mockery::mock(StrictInteger::class));
        $maximum->shouldReceive('getValue')
            ->andReturn($maximumValue = 222);
        /** @var StrictInteger|\Mockery\MockInterface $numberOfRolls */
        $numberOfRolls = \Mockery::mock(StrictInteger::class);
        $numberOfRolls->shouldReceive('getValue')
            ->andReturn($intNumberOfRolls = 5);
        /** @var DiceRollBuilder|\Mockery\MockInterface $diceRollBuilder */
        $diceRollBuilder = \Mockery::mock(DiceRollBuilder::class);
        $diceRoll = \Mockery::mock(DiceRoll::class);
        $diceRollCreateParameters = [];
        $diceRollBuilder->shouldReceive('create')
            ->andReturnUsing(function () use (&$diceRollCreateParameters, $diceRoll) {
                $diceRollCreateParameters[] = func_get_args();
                return $diceRoll;
            });
        $diceRoll->shouldReceive('getRollSequence')
            ->andReturnValues([1, 2, 3, 4, 5]);
        $diceRoll->shouldReceive('getRolledValue')
            ->andReturn($diceRollValue = \Mockery::mock(StrictInteger::class));
        $diceRollValue->shouldReceive('getValue')
            ->andReturn($diceRollIntValue = 123);
        $diceRoll->shouldReceive('getDice')
            ->andReturn($dice);
        $diceRollValue->shouldReceive('getValue')
            ->andReturn($diceRollIntValue = 123);
        /** @var RollOnInterface|\Mockery\MockInterface $bonusRollOn */
        $bonusRollOn = \Mockery::mock(RollOnInterface::class);
        $bonusRollOn->shouldReceive('shouldHappen')
            ->andReturn(false);
        $bonusRollOn->shouldReceive('getLastRollSummary')
            ->andReturn(0);
        /** @var RollOnInterface|\Mockery\MockInterface $malusRollOn */
        $malusRollOn = \Mockery::mock(RollOnInterface::class);
        $malusRollOn->shouldReceive('shouldHappen')
            ->andReturn(false);
        $malusRollOn->shouldReceive('getLastRollSummary')
            ->andReturn(0);
        $roll = new Roll($dice, $numberOfRolls, $diceRollBuilder, $bonusRollOn, $malusRollOn);
        $lastRollSummary = $roll->roll();
        $this->assertSame($lastRollSummary, $roll->getLastRollSummary());
        $this->assertGreaterThanOrEqual($minimumValue * $numberOfRolls->getValue(), $lastRollSummary);
        $this->assertLessThanOrEqual($maximumValue * $numberOfRolls->getValue(), $lastRollSummary);
        $this->assertSame(
            $roll->getLastRollSummary(),
            array_sum(
                array_map(
                    function (StrictInteger $numberOfRolls) {
                        return $numberOfRolls->getValue();
                    },
                    $roll->getLastRolledNumbers()
                )
            )
        );
        $summary = 0;
        $currentRollSequence = 1;
        foreach ($roll->getLastDiceRolls() as $diceRoll) {
            $this->assertInstanceOf(DiceRoll::class, $diceRoll);
            $this->assertSame($dice, $diceRoll->getDice(), 'Uses given dice');
            $summary += $diceRoll->getRolledValue()->getValue();
            $this->assertSame($currentRollSequence, $diceRoll->getRollSequence() /* integer from the mock */, 'Roll sequence is not successive');
            $currentRollSequence++;
        }
        $this->assertSame($roll->getLastRollSummary(), $summary);
        $this->assertSame($roll->getLastDiceRolls(), $roll->getLastStandardDiceRolls());
    }


    /**
     * @test
     * @depends can_roll
     * @expectedException \LogicException
     */
    public function bonus_and_malus_triggered_on_same_values_cause_exception()
    {
        /** @var Dice|\Mockery\MockInterface $dice */
        $dice = \Mockery::mock(Dice::class);
        $dice->shouldReceive('getMinimum')
            ->andReturn($minimum = \Mockery::mock(StrictInteger::class));
        $minimum->shouldReceive('getValue')
            ->andReturn($minimumValue = 1);
        $dice->shouldReceive('getMaximum')
            ->andReturn($maximum = \Mockery::mock(StrictInteger::class));
        $maximum->shouldReceive('getValue')
            ->andReturn($maximumValue = 2);
        $this->assertGreaterThan($minimumValue, $maximumValue);
        /** @var StrictInteger|\Mockery\MockInterface $numberOfRolls */
        $numberOfRolls = \Mockery::mock(StrictInteger::class);
        $numberOfRolls->shouldReceive('getValue')
            ->andReturn(1);
        /** @var DiceRollBuilder|\Mockery\MockInterface $diceRollBuilder */
        $diceRollBuilder = \Mockery::mock(DiceRollBuilder::class);
        $diceRoll = \Mockery::mock(DiceRoll::class);
        $diceRoll->shouldReceive('getRolledValue')
            ->andReturn($diceRollValue = \Mockery::mock(StrictInteger::class));
        $diceRollValue->shouldReceive('getValue')
            ->andReturn($diceRollIntValue = 2);
        /** @var RollOnInterface|\Mockery\MockInterface $bonusRollOn */
        $bonusRollOn = \Mockery::mock(RollOnInterface::class);
        $bonusRollOn->shouldReceive('shouldHappen')
            ->andReturn(true /* happens anytime */);
        /** @var RollOnInterface|\Mockery\MockInterface $malusRollOn */
        $malusRollOn = \Mockery::mock(RollOnInterface::class);
        $malusRollOn->shouldReceive('shouldHappen')
            ->andReturn(true /* happens anytime */);
        new Roll($dice, $numberOfRolls, $diceRollBuilder, $bonusRollOn, $malusRollOn);
    }

    /**
     * @test
     * @depends can_roll
     */
    public function bonus_roll_can_happen()
    {
        /** @var Dice|\Mockery\MockInterface $dice */
        $dice = \Mockery::mock(Dice::class);
        $dice->shouldReceive('getMinimum')
            ->andReturn($minimum = \Mockery::mock(StrictInteger::class));
        $minimum->shouldReceive('getValue')
            ->andReturn($minimumValue = 1);
        $dice->shouldReceive('getMaximum')
            ->andReturn($maximum = \Mockery::mock(StrictInteger::class));
        $maximum->shouldReceive('getValue')
            ->andReturn($maximumValue = 2);
        $this->assertGreaterThan($minimumValue, $maximumValue);
        /** @var StrictInteger|\Mockery\MockInterface $numberOfRolls */
        $numberOfRolls = \Mockery::mock(StrictInteger::class);
        $numberOfRolls->shouldReceive('getValue')
            ->andReturn(1);
        /** @var DiceRollBuilder|\Mockery\MockInterface $diceRollBuilder */
        $diceRollBuilder = \Mockery::mock(DiceRollBuilder::class);
        $diceRoll = \Mockery::mock(DiceRoll::class);
        $diceRollCreateParameters = [];
        $diceRollBuilder->shouldReceive('create')
            ->andReturnUsing(function () use (&$diceRollCreateParameters, $diceRoll) {
                $diceRollCreateParameters[] = func_get_args();
                return $diceRoll;
            });
        $diceRoll->shouldReceive('getRolledValue')
            ->andReturn($diceRollValue = \Mockery::mock(StrictInteger::class));
        $diceRollValue->shouldReceive('getValue')
            ->andReturn($diceRollIntValue = 2);
        /** @var RollOnInterface|\Mockery\MockInterface $bonusRollOn */
        $bonusRollOn = \Mockery::mock(RollOnInterface::class);
        $bonusRollOn->shouldReceive('shouldHappen')
            ->with($diceRollIntValue)
            ->andReturn(true);
        $bonusRollOn->shouldReceive('shouldHappen')
            ->andReturn(false);
        $bonusRollOn->shouldReceive('getRoll')
            ->andReturn($bonusRoll = \Mockery::mock(Roll::class));
        $bonusRoll->shouldReceive('roll')
            ->atLeast()->once();
        $bonusRoll->shouldReceive('getLastDiceRolls')
            ->andReturn([$bonusDiceRoll = \Mockery::mock(DiceRoll::class)]);
        $bonusDiceRoll->shouldReceive('getRolledValue')
            ->andReturn($bonusDiceRollValue = \Mockery::mock(StrictInteger::class));
        $bonusDiceRollValue->shouldReceive('getValue')
            ->andReturn($bonusDiceRollIntValue = 12345);
        /** @var RollOnInterface|\Mockery\MockInterface $malusRollOn */
        $malusRollOn = \Mockery::mock(RollOnInterface::class);
        $malusRollOn->shouldReceive('shouldHappen')
            ->andReturn(false);
        $malusRollOn->shouldReceive('getLastRollSummary')
            ->andReturn(0);
        $roll = new Roll($dice, $numberOfRolls, $diceRollBuilder, $bonusRollOn, $malusRollOn);
        $this->assertTrue($roll->getBonusRollOn()->shouldHappen($maximumValue));
        $bonusRollCount = 0;
        for ($attempt = 1; $attempt < 1000; $attempt++) {
            $roll->roll();
            foreach ($roll->getLastDiceRolls() as $diceRoll) {
                if ($diceRoll === $bonusDiceRoll) {
                    $bonusRollCount++;
                }
            }
            if ($bonusRollCount > 0) {
                break;
            }
        }
        $this->assertGreaterThan(0, $bonusRollCount);
        $this->assertGreaterThanOrEqual($minimumValue + $bonusDiceRollIntValue, $roll->getLastRollSummary());
        $this->assertSame(count($roll->getLastStandardDiceRolls()) + $bonusRollCount, count($roll->getLastDiceRolls()));
    }

    /**
     * @test
     * @depends bonus_roll_can_happen
     */
    public function malus_roll_can_happen()
    {
        /** @var Dice|\Mockery\MockInterface $dice */
        $dice = \Mockery::mock(Dice::class);
        $dice->shouldReceive('getMinimum')
            ->andReturn($minimum = \Mockery::mock(StrictInteger::class));
        $minimum->shouldReceive('getValue')
            ->andReturn($minimumValue = 1);
        $dice->shouldReceive('getMaximum')
            ->andReturn($maximum = \Mockery::mock(StrictInteger::class));
        $maximum->shouldReceive('getValue')
            ->andReturn($maximumValue = 2);
        $this->assertGreaterThan($minimumValue, $maximumValue);
        /** @var StrictInteger|\Mockery\MockInterface $numberOfRolls */
        $numberOfRolls = \Mockery::mock(StrictInteger::class);
        $numberOfRolls->shouldReceive('getValue')
            ->andReturn(1);
        /** @var DiceRollBuilder|\Mockery\MockInterface $diceRollBuilder */
        $diceRollBuilder = \Mockery::mock(DiceRollBuilder::class);
        $diceRoll = \Mockery::mock(DiceRoll::class);
        $diceRollCreateParameters = [];
        $diceRollBuilder->shouldReceive('create')
            ->andReturnUsing(function () use (&$diceRollCreateParameters, $diceRoll) {
                $diceRollCreateParameters[] = func_get_args();
                return $diceRoll;
            });
        $diceRoll->shouldReceive('getRolledValue')
            ->andReturn($diceRollValue = \Mockery::mock(StrictInteger::class));
        $diceRollValue->shouldReceive('getValue')
            ->andReturn($diceRollIntValue = 1);
        /** @var RollOnInterface|\Mockery\MockInterface $bonusRollOn */
        $bonusRollOn = \Mockery::mock(RollOnInterface::class);
        $bonusRollOn->shouldReceive('shouldHappen')
            ->andReturn(false);
        $bonusRollOn->shouldReceive('getLastRollSummary')
            ->andReturn(0);
        /** @var RollOnInterface|\Mockery\MockInterface $malusRollOn */
        $malusRollOn = \Mockery::mock(RollOnInterface::class);
        $malusRollOn->shouldReceive('shouldHappen')
            ->with($diceRollIntValue)
            ->andReturn(true);
        $malusRollOn->shouldReceive('shouldHappen')
            ->andReturn(false);
        $malusRollOn->shouldReceive('getRoll')
            ->andReturn($malusRoll = \Mockery::mock(Roll::class));
        $malusRoll->shouldReceive('roll')
            ->atLeast()->once();
        $malusRoll->shouldReceive('getLastDiceRolls')
            ->andReturn([$malusDiceRoll = \Mockery::mock(DiceRoll::class)]);
        $malusDiceRoll->shouldReceive('getRolledValue')
            ->andReturn($malusDiceRollValue = \Mockery::mock(StrictInteger::class));
        $malusDiceRollValue->shouldReceive('getValue')
            ->andReturn($malusDiceRollIntValue = -12345);
        $roll = new Roll($dice, $numberOfRolls, $diceRollBuilder, $bonusRollOn, $malusRollOn);
        $this->assertTrue($roll->getMalusRollOn()->shouldHappen($minimumValue));
        $malusRollCount = 0;
        for ($attempt = 1; $attempt < 1000; $attempt++) {
            $roll->roll();
            foreach ($roll->getLastDiceRolls() as $diceRoll) {
                if ($diceRoll === $malusDiceRoll) {
                    $malusRollCount++;
                }
            }
            if ($malusRollCount > 0) {
                break;
            }
        }
        $this->assertGreaterThan(0, $malusRollCount);
        $this->assertGreaterThanOrEqual($minimumValue + $malusDiceRollIntValue, $roll->getLastRollSummary());
        $this->assertSame(count($roll->getLastStandardDiceRolls()) + $malusRollCount, count($roll->getLastDiceRolls()));
    }
}
