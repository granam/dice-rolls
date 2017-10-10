<?php
declare(strict_types=1);

namespace DrdPlus\Tests\DiceRolls\Templates\Numbers;

use DrdPlus\DiceRolls\Templates\Numbers\Four;
use Granam\Integer\IntegerInterface;
use PHPUnit\Framework\TestCase;

class FourTest extends TestCase
{
    /**
     * @test
     */
    public function I_can_use_it()
    {
        $four = Four::getIt();
        self::assertSame(4, $four->getValue());
        self::assertSame('4', "$four");
        self::assertInstanceOf(IntegerInterface::class, $four);
    }
}