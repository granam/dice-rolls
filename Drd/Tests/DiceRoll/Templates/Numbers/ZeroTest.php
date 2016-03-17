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
        self::assertSame(0, $zero->getValue());
        self::assertSame('0', "$zero");
        self::assertInstanceOf(IntegerInterface::class, $zero);
    }
}
