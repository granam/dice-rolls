<?php
namespace Drd\DiceRoll\Templates\RollOn;

use Drd\DiceRoll\RollBuilderInterface;

class MalusRollOn2Test extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     *
     * @return MalusRollOn2
     */
    public function can_create_instance()
    {
        /** @var RollBuilderInterface $rollFactory */
        $rollFactory = \Mockery::mock(RollBuilderInterface::class);
        $instance = new MalusRollOn2($rollFactory);
        $this->assertNotNull($instance);

        return $instance;
    }

    /**
     * @param MalusRollOn2 $malusRollOn2
     *
     * @test
     * @depends can_create_instance
     */
    public function should_repeat_roll_on_six(MalusRollOn2 $malusRollOn2)
    {
        for ($rollValue = 1; $rollValue <= 10; $rollValue++) {
            if ($rollValue === 2) {
                $this->assertTrue($malusRollOn2->shouldHappen($rollValue));
            } else {
                $this->assertFalse($malusRollOn2->shouldHappen($rollValue), "Value of $rollValue should not trigger repeat roll");
            }
        }
    }
}
