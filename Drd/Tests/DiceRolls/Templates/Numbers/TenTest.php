<?php
namespace Drd\Tests\DiceRolls\Templates\Numbers;

use Drd\DiceRolls\Templates\Numbers\Ten;
use Granam\Integer\IntegerInterface;

class TenTest extends \PHPUnit_Framework_TestCase
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
