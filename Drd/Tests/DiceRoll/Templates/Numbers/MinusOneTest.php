<?php
namespace Drd\Tests\DiceRoll\Templates\Numbers;

use Drd\DiceRoll\Templates\Numbers\MinusOne;
use Granam\Integer\IntegerInterface;

class MinusOneTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_use_it()
    {
        $minusOne = MinusOne::getIt();
        $this->assertSame(-1, $minusOne->getValue());
        $this->assertSame('-1', "$minusOne");
        $this->assertInstanceOf(IntegerInterface::class, $minusOne);
    }
}
