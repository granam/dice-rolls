<?php
namespace Drd\Tests\DiceRoll;

use Drd\DiceRoll\Dice;

class DiceTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function I_can_use_dice_interface()
    {
        $this->assertTrue(interface_exists(Dice::class));
        $reflection = new \ReflectionClass(Dice::class);
        $methods = $reflection->getMethods();
        $this->assertCount(2, $methods);
        $this->assertTrue($reflection->hasMethod('getMinimum'));
        $getMinimum = new \ReflectionMethod(Dice::class, 'getMinimum');
        $this->assertSame(0, $getMinimum->getNumberOfParameters());
        $this->assertTrue($reflection->hasMethod('getMaximum'));
        $getMaximum = new \ReflectionMethod(Dice::class, 'getMaximum');
        $this->assertSame(0, $getMaximum->getNumberOfParameters());
    }
}
