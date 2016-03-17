<?php
namespace Drd\Tests\DiceRoll\Templates\Numbers;

use Drd\DiceRoll\Templates\Numbers\Two;
use Granam\Integer\IntegerInterface;

class TwoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_use_it()
    {
        $two = Two::getIt();
        self::assertSame(2, $two->getValue());
        self::assertSame('2', "$two");
        self::assertInstanceOf(IntegerInterface::class, $two);
    }
}
