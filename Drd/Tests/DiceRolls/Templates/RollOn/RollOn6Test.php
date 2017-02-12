<?php
namespace Drd\Tests\DiceRolls\Templates\RollOn;

use Drd\DiceRolls\Templates\RollOn\RollOn6;

class RollOn6Test extends AbstractRollOnTest
{

    /**
     * @test
     */
    public function I_get_agreement_on_six()
    {
        $rollOn6 = new RollOn6($this->createRoller());
        for ($value = -1; $value < 10; $value++) {
            self::assertSame($value === 6, $rollOn6->shouldHappen($value));
        }
        self::assertFalse($rollOn6->shouldHappen(PHP_INT_MIN));
        self::assertFalse($rollOn6->shouldHappen(PHP_INT_MAX));
    }
}