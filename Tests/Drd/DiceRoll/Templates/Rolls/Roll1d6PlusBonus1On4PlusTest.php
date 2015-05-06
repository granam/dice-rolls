<?php
namespace Drd\DiceRoll\Templates\Rolls;

class Roll1d6PlusBonus1On4PlusTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function can_create_instance()
    {
        $instance = new Roll1d6PlusBonus1On4Plus();
        $this->assertNotNull($instance);

        return $instance;
    }

    /**
     * @param Roll1d6PlusBonus1On4Plus $roll1d6PlusBonus1On4Plus
     *
     * @test
     * @depends can_create_instance
     */
    public function minimum_is_one(Roll1d6PlusBonus1On4Plus $roll1d6PlusBonus1On4Plus)
    {
        $this->assertSame(1, $roll1d6PlusBonus1On4Plus->getDice()->getMinimum()->getValue());
    }

    /**
     * @param Roll1d6PlusBonus1On4Plus $roll1d6PlusBonus1On4Plus
     *
     * @test
     * @depends can_create_instance
     */
    public function maximum_is_six(Roll1d6PlusBonus1On4Plus $roll1d6PlusBonus1On4Plus)
    {
        $this->assertSame(6, $roll1d6PlusBonus1On4Plus->getDice()->getMaximum()->getValue());
    }

    /**
     * @param Roll1d6PlusBonus1On4Plus $roll1d6PlusBonus1On4Plus
     *
     * @test
     * @depends can_create_instance
     */
    public function at_least_one_roll(Roll1d6PlusBonus1On4Plus $roll1d6PlusBonus1On4Plus)
    {
        $this->assertSame(1, $roll1d6PlusBonus1On4Plus->getNumberOfStandardRolls()->getValue());
        $this->assertGreaterThanOrEqual($roll1d6PlusBonus1On4Plus->getDice()->getMinimum()->getValue(), $roll1d6PlusBonus1On4Plus->roll());
        $this->greaterThanOrEqual(1, count($roll1d6PlusBonus1On4Plus->getLastDiceRolls()));
    }

    /**
     * @param Roll1d6PlusBonus1On4Plus $roll1d6PlusBonus1On4Plus
     *
     * @test
     * @depends can_create_instance
     */
    public function bonus_roll_can_happen(Roll1d6PlusBonus1On4Plus $roll1d6PlusBonus1On4Plus)
    {
        $rolledValue = 0;
        $minimalBonusRollCounts = 2;
        for ($attempt = 1; $attempt < 1000; $attempt++) {
            $rolledValue = $roll1d6PlusBonus1On4Plus->roll();
            // d6 is rolled only once by default, any other roll has to be bonus
            if (count($roll1d6PlusBonus1On4Plus->getLastDiceRolls()) > 1 + $minimalBonusRollCounts /* standard roll plus two or more bonus rolls */) {
                break;
            }
        }
        $this->assertGreaterThanOrEqual(1 /* minimal standard roll */ + $minimalBonusRollCounts - 1 /* last bonus roll is zero */, $rolledValue); // lastly rolled value sum is standard roll plus bonus
        $this->assertSame(1, count($roll1d6PlusBonus1On4Plus->getLastStandardDiceRolls()));
        $this->greaterThanOrEqual(1 + $minimalBonusRollCounts, count($roll1d6PlusBonus1On4Plus->getLastDiceRolls()));
        $bonusDiceRollCount = count($roll1d6PlusBonus1On4Plus->getBonusRollOn()->getRoll()->getLastDiceRolls());
        $this->assertGreaterThanOrEqual(2, $bonusDiceRollCount);
        // only the last bonus roll can be +0, previous should be +1
        $this->assertGreaterThanOrEqual($bonusDiceRollCount - 1, $roll1d6PlusBonus1On4Plus->getBonusRollOn()->getRoll()->getLastRollSummary());
        $this->assertLessThanOrEqual(
            $rolledValue, // standard roll + one or MORE bonus rolls
            $roll1d6PlusBonus1On4Plus->getLastStandardDiceRolls()[0]->getEvaluatedValue()->getValue()
            + $roll1d6PlusBonus1On4Plus->getBonusRollOn()->getRoll()->getLastStandardDiceRolls()[0]->getEvaluatedValue()->getValue()
        );
        $this->assertGreaterThanOrEqual(4, $roll1d6PlusBonus1On4Plus->getBonusRollOn()->getRoll()->getLastStandardDiceRolls()[0]->getRolledNumber()->getValue());
        $this->assertFalse($roll1d6PlusBonus1On4Plus->getMalusRollOn()->happened());
    }
}
