<?php
namespace Drd\DiceRoll\Templates\RollOn;

use Drd\DiceRoll\RollBuilderInterface;

class Bonus1RollOn4PlusTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     *
     * @return Bonus1RollOn4Plus
     */
    public function can_create_instance()
    {
        /** @var RollBuilderInterface $rollFactory */
        $rollFactory = \Mockery::mock(RollBuilderInterface::class);
        $instance = new Bonus1RollOn4Plus($rollFactory);
        $this->assertNotNull($instance);

        return $instance;
    }

    /**
     * @param Bonus1RollOn4Plus $bonus1RollOn4Plus
     *
     * @test
     * @depends can_create_instance
     */
    public function should_repeat_roll_on_four_plus(Bonus1RollOn4Plus $bonus1RollOn4Plus)
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
