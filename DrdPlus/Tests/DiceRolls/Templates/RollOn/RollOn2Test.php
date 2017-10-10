<?php
declare(strict_types=1);

namespace DrdPlus\Tests\DiceRolls\Templates\RollOn;

use DrdPlus\DiceRolls\Templates\RollOn\RollOn2;

class RollOn2Test extends AbstractRollOnTest
{

    /**
     * @test
     */
    public function I_get_agreement_on_two()
    {
        $rollOn2 = new RollOn2($this->createRoller());
        for ($value = -1; $value < 6; $value++) {
            self::assertSame($value === 2, $rollOn2->shouldHappen($value));
        }
        self::assertFalse($rollOn2->shouldHappen(PHP_INT_MIN));
        self::assertFalse($rollOn2->shouldHappen(PHP_INT_MAX));
    }

}