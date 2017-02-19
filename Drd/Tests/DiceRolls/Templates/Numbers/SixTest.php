<?php
namespace Drd\Tests\DiceRolls\Templates\Numbers;

use Drd\DiceRolls\Templates\Numbers\Six;
use Granam\Integer\IntegerInterface;
use PHPUnit\Framework\TestCase;

class SixTest extends TestCase
{
    /**
     * @test
     */
    public function I_can_use_it()
    {
        $six = Six::getIt();
        self::assertSame(6, $six->getValue());
        self::assertSame('6', "$six");
        self::assertInstanceOf(IntegerInterface::class, $six);
    }
}