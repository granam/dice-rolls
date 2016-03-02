<?php
namespace Drd\Tests\DiceRoll\Templates\RollOn;

use Drd\DiceRoll\Templates\RollOn\RollOn12;

class RollOn12Test extends AbstractRollOnTest
{

    /**
     * @test
     */
    public function I_get_agreement_on_twelve()
    {
        $rollOn12 = new RollOn12($this->createRoller());
        for ($value = -1; $value < 20; $value++) {
            $this->assertSame($value === 12, $rollOn12->shouldHappen($value));
        }
        $this->assertFalse($rollOn12->shouldHappen(PHP_INT_MIN));
        $this->assertFalse($rollOn12->shouldHappen(PHP_INT_MAX));
    }
}
