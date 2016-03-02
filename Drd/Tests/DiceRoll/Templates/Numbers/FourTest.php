<?php
namespace Drd\Tests\DiceRoll\Templates\Numbers;

use Drd\DiceRoll\Templates\Numbers\Four;
use Granam\Integer\IntegerInterface;

class FourTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_use_it()
    {
        $four = Four::getIt();
        $this->assertSame(4, $four->getValue());
        $this->assertSame('4', "$four");
        $this->assertInstanceOf(IntegerInterface::class, $four);
    }
}
