<?php
namespace Drd\Tests\DiceRoll;

use Drd\DiceRoll\RollOn;

class RollOnTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function I_can_use_roll_on_interface()
    {
        $this->assertTrue(interface_exists(RollOn::class));
        $reflection = new \ReflectionClass(RollOn::class);
        $this->assertTrue($reflection->hasMethod('shouldHappen'));
        $shouldHappen = new \ReflectionMethod(RollOn::class, 'shouldHappen');
        $parameters = $shouldHappen->getParameters();
        $this->assertCount(1, $parameters);
        $parameter = current($parameters);
        /** @var \ReflectionParameter $parameter */
        $this->assertFalse($parameter->isOptional());
        $this->assertSame('rolledValue', $parameter->getName());
        $this->assertTrue($reflection->hasMethod('rollDices'));
    }
}
