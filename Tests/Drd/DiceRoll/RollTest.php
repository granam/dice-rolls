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
        $dice = \Mockery::mock(Dice::class);
        $dice->shouldReceive('getMinimum')
            ->andReturn($minimum = \Mockery::mock(StrictInteger::class));
        $minimum->shouldReceive('getValue')
            ->andReturn(1);
        $dice->shouldReceive('getMaximum')
            ->andReturn($maximum = \Mockery::mock(StrictInteger::class));
        $maximum->shouldReceive('getValue')
            ->andReturn(2);
        $instance = new Roll($dices = [$dice]);
        $this->assertInstanceOf(Roll::class, $instance);
        $this->assertSame($dices, $instance->getDices());

        return $instance;
    }

    /**
     * @test
     * @depends can_create_instance
     */
    public function default_values_as_expected()
    {
        $dice = \Mockery::mock(Dice::class);
        $dice->shouldReceive('getMinimum')
            ->andReturn($minimum = \Mockery::mock(StrictInteger::class));
        $minimum->shouldReceive('getValue')
            ->andReturn(1);
        $dice->shouldReceive('getMaximum')
            ->andReturn($maximum = \Mockery::mock(StrictInteger::class));
        $maximum->shouldReceive('getValue')
            ->andReturn(2);
        $roll = new Roll([$dice]);
        $this->assertInstanceOf(Roll::class, $roll);
        $this->assertSame(1, $roll->getRollNumber());
        $this->assertSame(0 /* never */, $roll->getRepeatOnValue());
    }

    /**
     * @test
     * @depends can_create_instance
     * @expectedException \LogicException
     */
    public function no_dices_cause_exception()
    {
        new Roll([]);
    }

    /**
     * @test
     * @depends can_create_instance
     * @expectedException \LogicException
     */
    public function infinite_repeat_cause_exception()
    {
        $dice = \Mockery::mock(Dice::class);
        $dice->shouldReceive('getMinimum')
            ->andReturn($minimum = \Mockery::mock(StrictInteger::class));
        $minimum->shouldReceive('getValue')
            ->andReturn($minimumValue = 12345);
        $dice->shouldReceive('getMaximum')
            ->andReturn($maximum = \Mockery::mock(StrictInteger::class));
        $maximum->shouldReceive('getValue')
            ->andReturn($maximumValue = $minimumValue);
        $this->assertSame($maximumValue, $minimumValue); // only one number can be rolled
        new Roll([$dice], 1 /* count of rolls, if no bonus happens */, $maximumValue /* bonus happens every time */);
    }

    /**
     * @test
     * @depends can_create_instance
     * @expectedException \LogicException
     */
    public function zero_roll_count_cause_exception()
    {
        $dice = \Mockery::mock(Dice::class);
        $dice->shouldReceive('getMinimum')
            ->andReturn($minimum = \Mockery::mock(StrictInteger::class));
        $minimum->shouldReceive('getValue')
            ->andReturn($minimumValue = 12345);
        $dice->shouldReceive('getMaximum')
            ->andReturn($maximum = \Mockery::mock(StrictInteger::class));
        $maximum->shouldReceive('getValue')
            ->andReturn(98765);
        new Roll([$dice], 0 /* no roll at all */);
    }

    /**
     * @test
     * @depends default_values_as_expected
     */
    public function gives_same_values_as_got()
    {
        $dice = \Mockery::mock(Dice::class);
        $dice->shouldReceive('getMinimum')
            ->andReturn($minimum = \Mockery::mock(StrictInteger::class));
        $minimum->shouldReceive('getValue')
            ->andReturn($minimumValue = 12345);
        $dice->shouldReceive('getMaximum')
            ->andReturn($maximum = \Mockery::mock(StrictInteger::class));
        $maximum->shouldReceive('getValue')
            ->andReturn(98765);
        $roll = new Roll($dices = [$dice], $rollNumber = 123, $repeatOnValue = 456);
        $this->assertSame($dices, $roll->getDices());
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
        $this->assertSame([], $roll->getLastRoll());
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
        $dice = \Mockery::mock(Dice::class);
        $dice->shouldReceive('getMinimum')
            ->andReturn($minimum = \Mockery::mock(StrictInteger::class));
        $minimum->shouldReceive('getValue')
            ->andReturn($minimumValue = 12345);
        $dice->shouldReceive('getMaximum')
            ->andReturn($maximum = \Mockery::mock(StrictInteger::class));
        $maximum->shouldReceive('getValue')
            ->andReturn($maximumValue = 98765);
        $roll = new Roll([$dice], $rollNumber = 123, $repeatOnValue = 456);
        $lastDiceRolls = $roll->roll();
        $this->assertSame($lastDiceRolls, $roll->getLastRoll());
        $this->assertGreaterThanOrEqual($minimumValue * $rollNumber, $roll->getLastRollSummary());
        $this->assertLessThanOrEqual($maximumValue * $rollNumber, $roll->getLastRollSummary());
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
        foreach ($roll->getLastRoll() as $diceRoll) {
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
        $roll = new Roll([$dice], $rollNumber = 1, $repeatOnValue = 2);
        $this->assertGreaterThanOrEqual($minimumValue, $repeatOnValue);
        $this->assertLessThanOrEqual($maximumValue, $repeatOnValue);
        $bonusRollCount = 0;
        for ($attempt = 1; $attempt < 1000; $attempt++) {
            foreach ($roll->roll() as $diceRoll) {
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
