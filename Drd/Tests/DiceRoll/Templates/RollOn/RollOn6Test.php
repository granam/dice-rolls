<?php
namespace Drd\Tests\DiceRoll\Templates\RollOn;

use Drd\DiceRoll\Templates\RollOn\RollOn6;

class RollOn6Test extends AbstractRollOnTest
{

    /**
     * @test
     */
    public function I_get_agreement_on_six()
    {
        $rollOn6 = new RollOn6($this->createRoller());
        for ($value = -1; $value < 10; $value++) {
            $this->assertSame($value === 6, $rollOn6->shouldHappen($value));
        }
        $this->assertFalse($rollOn6->shouldHappen(PHP_INT_MIN));
        $this->assertFalse($rollOn6->shouldHappen(PHP_INT_MAX));
    }
}