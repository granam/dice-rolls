<?php
namespace Drd\Tests\DiceRoll\Templates\Numbers;

use Drd\DiceRoll\Templates\Numbers\One;
use Granam\Integer\IntegerInterface;

class OneTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_use_it()
    {
        $one = One::getIt();
        $this->assertSame(1, $one->getValue());
        $this->assertSame('1', "$one");
        $this->assertInstanceOf(IntegerInterface::class, $one);
    }
}
