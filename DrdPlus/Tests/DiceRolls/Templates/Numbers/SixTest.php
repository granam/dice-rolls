<?php
declare(strict_types=1);

namespace DrdPlus\Tests\DiceRolls\Templates\Numbers;

use DrdPlus\DiceRolls\Templates\Numbers\Six;
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