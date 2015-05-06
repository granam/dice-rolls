<?php
namespace Drd\DiceRoll\Templates\RollOn;

use Drd\DiceRoll\RollBuilderInterface;

class RollOn12Test extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     *
     * @return RollOn12
     */
    public function can_create_instance()
    {
        /** @var RollBuilderInterface $rollFactory */
        $rollFactory = \Mockery::mock(RollBuilderInterface::class);
        $instance = new RollOn12($rollFactory);
        $this->assertNotNull($instance);

        return $instance;
    }

    /**
     * @param RollOn12 $rollOn12
     *
     * @test
     * @depends can_create_instance
     */
    public function should_repeat_roll_on_six(RollOn12 $rollOn12)
    {
        for ($rollValue = 1; $rollValue <= 20; $rollValue++) {
            if ($rollValue === 12) {
                $this->assertTrue($rollOn12->shouldHappen($rollValue));
            } else {
                $this->assertFalse($rollOn12->shouldHappen($rollValue), "Value of $rollValue should not trigger repeat roll");
            }
        }
    }
}
