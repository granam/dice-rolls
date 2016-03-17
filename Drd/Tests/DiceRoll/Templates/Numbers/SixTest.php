<?php
namespace Drd\Tests\DiceRoll\Templates\Numbers;

use Drd\DiceRoll\Templates\Numbers\Six;
use Granam\Integer\IntegerInterface;

class SixTest extends \PHPUnit_Framework_TestCase
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
