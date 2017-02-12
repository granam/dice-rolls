<?php
namespace Drd\Tests\DiceRolls\Templates\Numbers;

use Drd\DiceRolls\Templates\Numbers\Zero;
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
