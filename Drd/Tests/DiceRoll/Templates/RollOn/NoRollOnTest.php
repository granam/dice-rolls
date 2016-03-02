<?php
namespace Drd\Tests\DiceRoll\Templates\RollOn;

use Drd\DiceRoll\Templates\RollOn\NoRollOn;

class NoRollOnTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function I_do_not_get_any_repeat_roll()
    {
        $noRollOn = NoRollOn::getIt();
        $this->assertSame($noRollOn, NoRollOn::getIt());
        $this->assertEquals($noRollOn, new NoRollOn());

        $this->assertEquals([], $noRollOn->rollDices(123));
        foreach ([-123, 0, 456, 7891011] as $rollValue) {
            $this->assertFalse($noRollOn->shouldHappen($rollValue), "No value should trigger repeat roll");
        }
        $this->assertEquals([], $noRollOn->rollDices(456));
    }

}
