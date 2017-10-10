<?php
declare(strict_types=1);

namespace DrdPlus\Tests\DiceRolls\Templates\Numbers;

use DrdPlus\DiceRolls\Templates\Numbers\MinusOne;
use Granam\Integer\IntegerInterface;
use PHPUnit\Framework\TestCase;

class MinusOneTest extends TestCase
{
    /**
     * @test
     */
    public function I_can_use_it()
    {
        $minusOne = MinusOne::getIt();
        self::assertSame(-1, $minusOne->getValue());
        self::assertSame('-1', "$minusOne");
        self::assertInstanceOf(IntegerInterface::class, $minusOne);
    }
}