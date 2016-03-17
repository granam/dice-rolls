<?php
namespace Drd\Tests\DiceRoll\Templates\Numbers;

use Drd\DiceRoll\Templates\Numbers\Ten;
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
