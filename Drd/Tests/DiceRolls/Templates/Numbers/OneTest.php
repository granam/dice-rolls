<?php
namespace Drd\Tests\DiceRolls\Templates\Numbers;

use Drd\DiceRolls\Templates\Numbers\One;
use Granam\Integer\IntegerInterface;
use PHPUnit\Framework\TestCase;

class OneTest extends TestCase
{
    /**
     * @test
     */
    public function I_can_use_it()
    {
        $one = One::getIt();
        self::assertSame(1, $one->getValue());
        self::assertSame('1', "$one");
        self::assertInstanceOf(IntegerInterface::class, $one);
    }
}