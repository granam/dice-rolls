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
            ->andReturn($minimum = \Mockery::mock(StrictInteger::class));
        $minimum->shouldReceive('getValue')
            ->andReturn(1);
        $dice->shouldReceive('getMaximum')
            ->andReturn($maximum = \Mockery::mock(StrictInteger::class));
        $maximum->shouldReceive('getValue')
            ->andReturn(2);
        $instance = new Roll($dice);
        $this->assertInstanceOf(Roll::class, $instance);
        $this->assertSame($dice, $instance->getDice());

        return $instance;
    }

    /**
     * @test
     * @depends can_create_instance
     */
    public function default_values_as_expected()
    {
        /** @var Dice|\Mockery\MockInterface $dice */
        $dice = \Mockery::mock(Dice::class);
        $dice->shouldReceive('getMinimum')
            ->andReturn($minimum = \Mockery::mock(StrictInteger::class));
        $minimum->shouldReceive('getValue')
            ->andReturn(1);
        $dice->shouldReceive('getMaximum')
            ->andReturn($maximum = \Mockery::mock(StrictInteger::class));
        $maximum->shouldReceive('getValue')
            ->andReturn(2);
        $roll = new Roll($dice);
        $this->assertInstanceOf(Roll::class, $roll);
        $this->assertSame(1, $roll->getRollNumber()->getValue());
        $this->assertSame(0 /* never */, $roll->getRepeatOnValue()->getValue());
    }

    /**
     * @test
     * @depends can_create_instance
     * @expectedException \LogicException
     */
    public function infinite_repeat_cause_exception()
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
            ->andReturn($maximumValue = $minimumValue);
        $this->assertSame($maximumValue, $minimumValue); // only one number can be rolled in this test
        /** @var StrictInteger|\Mockery\MockInterface $rollNumber */
        $rollNumber = \Mockery::mock(StrictInteger::class);
        $rollNumber->shouldReceive('getValue')
            ->andReturn(1);/* count of rolls, if no bonus happens */
        /** @var StrictInteger|\Mockery\MockInterface $repeatOnValue */
        $repeatOnValue = \Mockery::mock(StrictInteger::class);
        $repeatOnValue->shouldReceive('getValue')
            ->andReturn($maximumValue); // count of rolls, if no bonus happens
        new Roll($dice, $rollNumber , $repeatOnValue /* bonus happens every time */);
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
        /** @var StrictInteger|\Mockery\MockInterface $rollNumber */
        $rollNumber = \Mockery::mock(StrictInteger::class);
        $rollNumber->shouldReceive('getValue')
            ->andReturn(0 /* no roll at all */);
        new Roll($dice, $rollNumber);
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
        /** @var StrictInteger|\Mockery\MockInterface $rollNumber */
        $rollNumber = \Mockery::mock(StrictInteger::class);
        $rollNumber->shouldReceive('getValue')
            ->andReturn(1 /* single roll */ );
        $roll = new Roll($dice, $rollNumber);
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
        $this->assertSame(1, count($roll->getLastRollNumbers()));
    }

    /**
     * @test
     * @depends default_values_as_expected
     */
    public function gives_same_values_as_got()
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
        /** @var StrictInteger|\Mockery\MockInterface $rollNumber */
        $rollNumber = \Mockery::mock(StrictInteger::class);
        $rollNumber->shouldReceive('getValue')
            ->andReturn(123);
        /** @var StrictInteger|\Mockery\MockInterface $repeatOnValue */
        $repeatOnValue = \Mockery::mock(StrictInteger::class);
        $repeatOnValue->shouldReceive('getValue')
            ->andReturn(456);
        $roll = new Roll($dice, $rollNumber, $repeatOnValue);
        $this->assertSame($dice, $roll->getDice());
        $this->assertSame($rollNumber, $roll->getRollNumber());
        $this->assertSame($repeatOnValue, $roll->getRepeatOnValue());
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
        $this->assertSame([], $roll->getLastRollNumbers());
    }

    /**
     * @param Roll $roll
     *
     * @test
     * @depends can_create_instance
     */
    public function roll_summary_is_zero_before_any_roll(Roll $roll)
    {
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
            ->andReturn($minimumValue = 12345);
        $dice->shouldReceive('getMaximum')
            ->andReturn($maximum = \Mockery::mock(StrictInteger::class));
        $maximum->shouldReceive('getValue')
            ->andReturn($maximumValue = 98765);
        /** @var StrictInteger|\Mockery\MockInterface $rollNumber */
        $rollNumber = \Mockery::mock(StrictInteger::class);
        $rollNumber->shouldReceive('getValue')
            ->andReturn(123);
        /** @var StrictInteger|\Mockery\MockInterface $repeatOnValue */
        $repeatOnValue = \Mockery::mock(StrictInteger::class);
        $repeatOnValue->shouldReceive('getValue')
            ->andReturn(456);
        $roll = new Roll($dice, $rollNumber, $repeatOnValue);
        $lastRollSummary = $roll->roll();
        $this->assertSame($lastRollSummary, $roll->getLastRollSummary());
        $this->assertGreaterThanOrEqual($minimumValue * $rollNumber->getValue(), $lastRollSummary);
        $this->assertLessThanOrEqual($maximumValue * $rollNumber->getValue(), $lastRollSummary);
        $this->assertSame(
            $roll->getLastRollSummary(),
            array_sum(
                array_map(
                    function (StrictInteger $rollNumber) {
                        return $rollNumber->getValue();
                    },
                    $roll->getLastRollNumbers()
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
        /** @var StrictInteger|\Mockery\MockInterface $rollNumber */
        $rollNumber = \Mockery::mock(StrictInteger::class);
        $rollNumber->shouldReceive('getValue')
            ->andReturn(123);
        /** @var StrictInteger|\Mockery\MockInterface $repeatOnValue */
        $repeatOnValue = \Mockery::mock(StrictInteger::class);
        $repeatOnValue->shouldReceive('getValue')
            ->andReturn(456);
        /** @var StrictInteger|\Mockery\MockInterface $rollNumber */
        $rollNumber = \Mockery::mock(StrictInteger::class);
        $rollNumber->shouldReceive('getValue')
            ->andReturn(1);
        /** @var StrictInteger|\Mockery\MockInterface $repeatOnValue */
        $repeatOnValue = \Mockery::mock(StrictInteger::class);
        $repeatOnValue->shouldReceive('getValue')
            ->andReturn(2);
        $roll = new Roll($dice, $rollNumber, $repeatOnValue);
        $this->assertGreaterThanOrEqual($minimumValue, $repeatOnValue->getValue());
        $this->assertLessThanOrEqual($maximumValue, $repeatOnValue->getValue());
        $bonusRollCount = 0;
        for ($attempt = 1; $attempt < 1000; $attempt++) {
            $roll->roll();
            foreach ($roll->getLastDiceRolls() as $diceRoll) {
                if ($diceRoll->isBonusRoll()) {
                    $bonusRollCount++;
                }
            }
            if ($bonusRollCount > 0) {
                break;
            }
        }
        $this->assertGreaterThan(0, $bonusRollCount);
    }
}
