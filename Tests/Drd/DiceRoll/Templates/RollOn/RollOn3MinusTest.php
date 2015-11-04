<?php
namespace Drd\DiceRoll\Templates\RollOn;

use Drd\DiceRoll\RollBuilderInterface;

class RollOn3MinusTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     *
     * @return RollOn3Minus
     */
    public function can_create_instance()
    {
        /** @var RollBuilderInterface $rollFactory */
        $rollFactory = \Mockery::mock(RollBuilderInterface::class);
        $instance = new RollOn3Minus($rollFactory);
        $this->assertNotNull($instance);

        return $instance;
    }

    /**
     * @param RollOn3Minus $malus1RollOn3Minus
     *
     * @test
     * @depends can_create_instance
     */
    public function should_repeat_roll_on_four_plus(RollOn3Minus $malus1RollOn3Minus)
    {
        for ($rollValue = 1; $rollValue <= 6; $rollValue++) {
            if ($rollValue <= 3) {
                $this->assertTrue($malus1RollOn3Minus->shouldHappen($rollValue));
            } else {
                $this->assertFalse($malus1RollOn3Minus->shouldHappen($rollValue), "Value of $rollValue should not trigger repeat roll");
            }
        }
    }
}