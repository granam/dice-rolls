<?php
namespace Drd\Tests\DiceRoll\Templates\RollOn;

use Drd\DiceRoll\Templates\RollOn\RollOn3Minus;

class RollOn3MinusTest extends AbstractRollOnTest
{
    /**
     * @test
     */
    public function I_get_agreement_on_three_and_less()
    {
        $rollOn3Minus = new RollOn3Minus($this->createRoller());
        for ($value = -1; $value < 6; $value++) {
            $this->assertSame($value <= 3, $rollOn3Minus->shouldHappen($value));
        }
        $this->assertTrue($rollOn3Minus->shouldHappen(PHP_INT_MIN));
        $this->assertFalse($rollOn3Minus->shouldHappen(PHP_INT_MAX));
    }

}
