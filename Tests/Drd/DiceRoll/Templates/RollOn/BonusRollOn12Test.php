<?php
namespace Drd\DiceRoll\Templates\RollOn;

use Drd\DiceRoll\RollBuilderInterface;

class BonusRollOn12Test extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     *
     * @return BonusRollOn12
     */
    public function can_create_instance()
    {
        /** @var RollBuilderInterface $rollFactory */
        $rollFactory = \Mockery::mock(RollBuilderInterface::class);
        $instance = new BonusRollOn12($rollFactory);
        $this->assertNotNull($instance);

        return $instance;
    }

    /**
     * @param BonusRollOn12 $bonusRollOn12
     *
     * @test
     * @depends can_create_instance
     */
    public function should_repeat_roll_on_six(BonusRollOn12 $bonusRollOn12)
    {
        for ($rollValue = 1; $rollValue <= 20; $rollValue++) {
            if ($rollValue === 12) {
                $this->assertTrue($bonusRollOn12->shouldHappen($rollValue));
            } else {
                $this->assertFalse($bonusRollOn12->shouldHappen($rollValue), "Value of $rollValue should not trigger repeat roll");
            }
        }
    }
}
