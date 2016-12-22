<?php
namespace Drd\Tests\DiceRoll\Templates\RollOn;

use Drd\DiceRoll\Templates\RollOn\NoRollOn;

class NoRollOnTest extends \PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        $instanceProperty = new \ReflectionProperty(NoRollOn::class, 'noRollOn');
        $instanceProperty->setAccessible(true);
        $instanceProperty->setValue(null, null); // workaround for PhpUnit coverage
    }

    /**
     * @test
     */
    public function I_do_not_get_any_repeat_roll()
    {
        $noRollOn = NoRollOn::getIt();
        self::assertSame($noRollOn, NoRollOn::getIt());
        self::assertEquals($noRollOn, new NoRollOn());

        self::assertEquals([], $noRollOn->rollDices(123));
        foreach ([-123, 0, 456, 7891011] as $rollValue) {
            self::assertFalse($noRollOn->shouldHappen($rollValue), 'No value should trigger repeat roll');
        }
        self::assertEquals([], $noRollOn->rollDices(456));
    }

}