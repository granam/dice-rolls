<?php
namespace Drd\Tests\DiceRoll\Templates\Numbers;

use Drd\DiceRoll\Templates\Numbers\Ten;
use Granam\Integer\IntegerInterface;

class TenTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_use_it()
    {
        $ten = Ten::getIt();
        $this->assertSame(10, $ten->getValue());
        $this->assertSame('10', "$ten");
        $this->assertInstanceOf(IntegerInterface::class, $ten);
    }
}
