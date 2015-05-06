<?php
namespace Drd\DiceRoll\Templates\RollOn;

use Drd\DiceRoll\RollBuilderInterface;

class RollOn6Test extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     *
     * @return RollOn6
     */
    public function can_create_instance()
    {
        /** @var RollBuilderInterface $rollFactory */
        $rollFactory = \Mockery::mock(RollBuilderInterface::class);
        $instance = new RollOn6($rollFactory);
        $this->assertNotNull($instance);

        return $instance;
    }

    /**
     * @param RollOn6 $rollOn6
     *
     * @test
     * @depends can_create_instance
     */
    public function should_repeat_roll_on_six(RollOn6 $rollOn6)
    {
        for ($rollValue = 1; $rollValue <= 10; $rollValue++) {
            if ($rollValue === 6) {
                $this->assertTrue($rollOn6->shouldHappen($rollValue));
            } else {
                $this->assertFalse($rollOn6->shouldHappen($rollValue), "Value of $rollValue should not trigger repeat roll");
            }
        }
    }
}
