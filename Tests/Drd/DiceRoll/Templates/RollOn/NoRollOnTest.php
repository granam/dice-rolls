<?php
namespace Drd\DiceRoll\Templates\RollOn;

use Drd\DiceRoll\DiceRoll;

class NoRollOnTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     *
     * @return NoRollOn
     */
    public function can_create_instance()
    {
        $instance = new NoRollOn();
        $this->assertNotNull($instance);

        return $instance;
    }

    /**
     * @param NoRollOn $noRollOn
     * @return NoRollOn
     *
     * @test
     * @depends can_create_instance
     */
    public function repeat_roll_should_never_happen(NoRollOn $noRollOn)
    {
        foreach ([-123, 0, 456, 7891011] as $rollValue) {
            $this->assertFalse($noRollOn->shouldHappen($rollValue), "No value should trigger repeat roll");
        }
        $this->assertFalse($noRollOn->happened());

        return $noRollOn;
    }

    /**
     * @param NoRollOn $noRollOn
     *
     * @test
     * @depends can_create_instance
     * @expectedException \LogicException
     */
    public function attempt_to_get_roll_cause_exception(NoRollOn $noRollOn)
    {
        $noRollOn->getRoll();
    }

    /**
     * @param NoRollOn $noRollOn
     *
     * @test
     * @depends can_create_instance
     * @expectedException \LogicException
     */
    public function attempt_to_evaluate_dice_roll_cause_exception(NoRollOn $noRollOn)
    {
        /** @var DiceRoll $diceRoll */
        $diceRoll = \Mockery::mock(DiceRoll::class);
        $noRollOn->evaluateDiceRoll($diceRoll);
    }

    /**
     * @param NoRollOn $noRollOn
     *
     * @test
     * @depends can_create_instance
     */
    public function last_roll_summary_is_always_zero(NoRollOn $noRollOn)
    {
        $this->assertSame(0, $noRollOn->getLastRollSummary());
    }
}
