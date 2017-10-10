<?php
declare(strict_types=1);

namespace DrdPlus\Tests\DiceRolls\Templates\Numbers;

use DrdPlus\DiceRolls\Templates\Numbers\Ten;
use Granam\Integer\IntegerInterface;
use PHPUnit\Framework\TestCase;

class TenTest extends TestCase
{
    /**
     * @test
     */
    public function I_can_use_it()
    {
        $ten = Ten::getIt();
        self::assertSame(10, $ten->getValue());
        self::assertSame('10', "$ten");
        self::assertInstanceOf(IntegerInterface::class, $ten);
    }
}