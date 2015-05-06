<?php
namespace Drd\DiceRoll\Templates\RollOn;

use Drd\DiceRoll\RollBuilderInterface;

class RollOn2Test extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     *
     * @return RollOn2
     */
    public function can_create_instance()
    {
        /** @var RollBuilderInterface $rollFactory */
        $rollFactory = \Mockery::mock(RollBuilderInterface::class);
        $instance = new RollOn2($rollFactory);
        $this->assertNotNull($instance);

        return $instance;
    }

    /**
     * @param RollOn2 $rollOn2
     *
     * @test
     * @depends can_create_instance
     */
    public function should_repeat_roll_on_six(RollOn2 $rollOn2)
    {
        for ($rollValue = 1; $rollValue <= 10; $rollValue++) {
            if ($rollValue === 2) {
                $this->assertTrue($rollOn2->shouldHappen($rollValue));
            } else {
                $this->assertFalse($rollOn2->shouldHappen($rollValue), "Value of $rollValue should not trigger repeat roll");
            }
        }
    }
}
