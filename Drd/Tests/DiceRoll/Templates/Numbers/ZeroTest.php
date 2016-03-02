<?php
namespace Drd\Tests\DiceRoll\Templates\Numbers;

use Drd\DiceRoll\Templates\Numbers\Zero;
use Granam\Integer\IntegerInterface;

class ZeroTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_use_it()
    {
        $zero = Zero::getIt();
        $this->assertSame(0, $zero->getValue());
        $this->assertSame('0', "$zero");
        $this->assertInstanceOf(IntegerInterface::class, $zero);
    }
}
