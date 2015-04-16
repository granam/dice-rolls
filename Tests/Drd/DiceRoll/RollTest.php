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
        /** @var RollOnInterface|\Mockery\MockInterface $bonusRollOn */
        $bonusRollOn = \Mockery::mock(RollOnInterface::class);
        $bonusRollOn->shouldReceive('shouldRepeatRoll')
            ->andReturn(false);
        /** @var RollOnInterface|\Mockery\MockInterface $malusRollOn */
        $malusRollOn = \Mockery::mock(RollOnInterface::class);
        $malusRollOn->shouldReceive('shouldRepeatRoll')
            ->andReturn(false);
        $instance = new Roll($dice, $numberOfRolls, $bonusRollOn, $malusRollOn);
        $this->assertInstanceOf(Roll::class, $instance);
        $this->assertSame($dice, $instance->getDice());

        return $instance;
    }

    /**
     * @test
     * @depends can_create_instance
     * @expectedException \LogicException
     */
    public function infinite_bonus_repeat_cause_exception()
    {
        /** @var Dice|\Mockery\MockInterface $dice */
        $dice = \Mockery::mock(Dice::class);
        $dice->shouldReceive('getMinimum')
            ->andReturn($diceMinimum = \Mockery::mock(StrictInteger::class));
        $diceMinimum->shouldReceive('getValue')
            ->andReturn($minimumValue = 12345);
        $dice->shouldReceive('getMaximum')
            ->andReturn($diceMaximum = \Mockery::mock(StrictInteger::class));
        $diceMaximum->shouldReceive('getValue')
            ->andReturn($maximumValue = $minimumValue + 1); // at least 2 possible values
        /** @var StrictInteger|\Mockery\MockInterface $numberOfRolls */
        $numberOfRolls = \Mockery::mock(StrictInteger::class);
        $numberOfRolls->shouldReceive('getValue')
            ->andReturn(1);/* count of rolls, if no bonus happens */
        /** @var RollOnInterface|\Mockery\MockInterface $bonusRollOn */
        $bonusRollOn = \Mockery::mock(RollOnInterface::class);
        $bonusRollOn->shouldReceive('shouldRepeatRoll')
            ->andReturn(true); // bonus happens for every value
        /** @var RollOnInterface|\Mockery\MockInterface $malusRollOn */
        $malusRollOn = \Mockery::mock(RollOnInterface::class);
        $malusRollOn->shouldReceive('shouldRepeatRoll')
            ->andReturn(false);
        new Roll($dice, $numberOfRolls , $bonusRollOn, $malusRollOn);
    }

    /**
     * @test
     * @depends can_create_instance
     * @expectedException \LogicException
     */
    public function infinite_malus_repeat_cause_exception()
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
            ->andReturn($maximumValue = $minimumValue + 1); // at least 2 possible values
        /** @var StrictInteger|\Mockery\MockInterface $numberOfRolls */
        $numberOfRolls = \Mockery::mock(StrictInteger::class);
        $numberOfRolls->shouldReceive('getValue')
            ->andReturn(1);/* count of rolls, if no bonus happens */
        /** @var RollOnInterface|\Mockery\MockInterface $bonusRollOn */
        $bonusRollOn = \Mockery::mock(RollOnInterface::class);
        $bonusRollOn->shouldReceive('shouldRepeatRoll')
            ->andReturn(false);
        /** @var RollOnInterface|\Mockery\MockInterface $malusRollOn */
        $malusRollOn = \Mockery::mock(RollOnInterface::class);
        $malusRollOn->shouldReceive('shouldRepeatRoll')
            ->andReturn(true); // malus happens for every value
        new Roll($dice, $numberOfRolls , $bonusRollOn, $malusRollOn);
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
        /** @var RollOnInterface|\Mockery\MockInterface $bonusRollOn */
        $bonusRollOn = \Mockery::mock(RollOnInterface::class);
        /** @var RollOnInterface|\Mockery\MockInterface $malusRollOn */
        $malusRollOn = \Mockery::mock(RollOnInterface::class);
        $malusRollOn->shouldReceive('shouldRepeatRoll');
        new Roll($dice, $numberOfRolls, $bonusRollOn, $malusRollOn);
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
            ->andReturn(1 /* single roll */ );
        /** @var RollOnInterface|\Mockery\MockInterface $bonusRollOn */
        $bonusRollOn = \Mockery::mock(RollOnInterface::class);
        $bonusRollOn->shouldReceive('shouldRepeatRoll')
            ->andReturn(false);
        $bonusRollOn->shouldReceive('getLastRollSummary')
            ->andReturn(0);
        /** @var RollOnInterface|\Mockery\MockInterface $malusRollOn */
        $malusRollOn = \Mockery::mock(RollOnInterface::class);
        $malusRollOn->shouldReceive('shouldRepeatRoll')
            ->andReturn(false);
        $malusRollOn->shouldReceive('getLastRollSummary')
            ->andReturn(0);
        $roll = new Roll($dice, $numberOfRolls, $bonusRollOn, $malusRollOn);
        $summary = 0;
        for ($cycle = 1; $cycle < 10; $cycle++) {
            $summary += $value = $roll->roll();
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
        /** @var RollOnInterface|\Mockery\MockInterface $bonusRollOn */
        $bonusRollOn = \Mockery::mock(RollOnInterface::class);
        $bonusRollOn->shouldReceive('shouldRepeatRoll')
            ->andReturn(false);
        /** @var RollOnInterface|\Mockery\MockInterface $malusRollOn */
        $malusRollOn = \Mockery::mock(RollOnInterface::class);
        $malusRollOn->shouldReceive('shouldRepeatRoll')
            ->andReturn(false);
        $roll = new Roll($dice, $numberOfRolls, $bonusRollOn, $malusRollOn);
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
            ->andReturn(123);
        /** @var RollOnInterface|\Mockery\MockInterface $bonusRollOn */
        $bonusRollOn = \Mockery::mock(RollOnInterface::class);
        $bonusRollOn->shouldReceive('shouldRepeatRoll')
            ->andReturn(false);
        $bonusRollOn->shouldReceive('getLastRollSummary')
            ->andReturn(0);
        /** @var RollOnInterface|\Mockery\MockInterface $malusRollOn */
        $malusRollOn = \Mockery::mock(RollOnInterface::class);
        $malusRollOn->shouldReceive('shouldRepeatRoll')
            ->andReturn(false);
        $malusRollOn->shouldReceive('getLastRollSummary')
            ->andReturn(0);
        $roll = new Roll($dice, $numberOfRolls, $bonusRollOn, $malusRollOn);
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
            $this->assertSame($currentRollSequence, $diceRoll->getRollSequence()->getValue(), 'Roll sequence is successive');
            $currentRollSequence++;
        }
        $this->assertSame($roll->getLastRollSummary(), $summary);
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
        /** @var RollOnInterface|\Mockery\MockInterface $bonusRollOn */
        $bonusRollOn = \Mockery::mock(RollOnInterface::class);
        $bonusRollOn->shouldReceive('shouldRepeatRoll')
            ->with(2)
            ->andReturn(true);
        $bonusRollOn->shouldReceive('shouldRepeatRoll')
            ->andReturn(false);
        $bonusRollOn->shouldReceive('getLastRollSummary')
            ->andReturn($bonusLastRollSummary = 111);
        $bonusRollOn->shouldReceive('getRoll')
            ->andReturn($bonusRoll = \Mockery::mock(Roll::class));
        $bonusRoll->shouldReceive('roll');
        $bonusRoll->shouldReceive('getLastDiceRolls')
            ->andReturn([$bonusDiceRoll = \Mockery::mock(DiceRoll::class)]);
        /** @var RollOnInterface|\Mockery\MockInterface $malusRollOn */
        $malusRollOn = \Mockery::mock(RollOnInterface::class);
        $malusRollOn->shouldReceive('shouldRepeatRoll')
            ->andReturn(false);
        $malusRollOn->shouldReceive('getLastRollSummary')
            ->andReturn(0);
        $roll = new Roll($dice, $numberOfRolls, $bonusRollOn, $malusRollOn);
        $this->assertSame(true, $roll->getBonusRollOn()->shouldRepeatRoll($maximumValue));
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
        $this->assertGreaterThanOrEqual($minimumValue + $bonusLastRollSummary, $roll->getLastRollSummary());
    }
}
