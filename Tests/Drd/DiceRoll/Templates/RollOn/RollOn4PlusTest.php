<?php
namespace Drd\DiceRoll\Templates\RollOn;

use Drd\DiceRoll\RollBuilderInterface;

class RollOn4PlusTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     *
     * @return RollOn4Plus
     */
    public function can_create_instance()
    {
        /** @var RollBuilderInterface $rollFactory */
        $rollFactory = \Mockery::mock(RollBuilderInterface::class);
        $instance = new RollOn4Plus($rollFactory);
        $this->assertNotNull($instance);

        return $instance;
    }

    /**
     * @param RollOn4Plus $bonus1RollOn4Plus
     *
     * @test
     * @depends can_create_instance
     */
    public function should_repeat_roll_on_four_plus(RollOn4Plus $bonus1RollOn4Plus)
    {
        for ($rollValue = 1; $rollValue <= 6; $rollValue++) {
            if ($rollValue >= 4) {
                $this->assertTrue($bonus1RollOn4Plus->shouldHappen($rollValue));
            } else {
                $this->assertFalse($bonus1RollOn4Plus->shouldHappen($rollValue), "Value of $rollValue should not trigger repeat roll");
            }
        }
    }
}
