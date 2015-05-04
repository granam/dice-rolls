<?php
namespace Drd\DiceRoll\Templates\RollOn;

use Drd\DiceRoll\RollBuilderInterface;

class BonusRollOn6Test extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     *
     * @return BonusRollOn6
     */
    public function can_create_instance()
    {
        /** @var RollBuilderInterface $rollFactory */
        $rollFactory = \Mockery::mock(RollBuilderInterface::class);
        $instance = new BonusRollOn6($rollFactory);
        $this->assertNotNull($instance);

        return $instance;
    }

    /**
     * @param BonusRollOn6 $bonusRollOn6
     *
     * @test
     * @depends can_create_instance
     */
    public function should_repeat_roll_on_six(BonusRollOn6 $bonusRollOn6)
    {
        for ($rollValue = 1; $rollValue <= 10; $rollValue++) {
            if ($rollValue === 6) {
                $this->assertTrue($bonusRollOn6->shouldHappen($rollValue));
            } else {
                $this->assertFalse($bonusRollOn6->shouldHappen($rollValue), "Value of $rollValue should not trigger repeat roll");
            }
        }
    }
}
