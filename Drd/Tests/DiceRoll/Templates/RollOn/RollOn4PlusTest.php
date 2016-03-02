<?php
namespace Drd\Tests\DiceRoll\Templates\RollOn;

use Drd\DiceRoll\Templates\RollOn\RollOn4Plus;

class RollOn4PlusTest extends AbstractRollOnTest
{

    /**
     * @test
     */
    public function I_get_agreement_on_four_and_more()
    {
        $rollOn4Plus = new RollOn4Plus($this->createRoller());
        for ($value = -1; $value < 6; $value++) {
            $this->assertSame($value >= 4, $rollOn4Plus->shouldHappen($value));
        }
        $this->assertFalse($rollOn4Plus->shouldHappen(PHP_INT_MIN));
        $this->assertTrue($rollOn4Plus->shouldHappen(PHP_INT_MAX));
    }
}