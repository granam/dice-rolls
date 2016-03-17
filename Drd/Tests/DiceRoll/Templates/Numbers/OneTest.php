<?php
namespace Drd\Tests\DiceRoll\Templates\Numbers;

use Drd\DiceRoll\Templates\Numbers\One;
use Granam\Integer\IntegerInterface;

class OneTest extends \PHPUnit_Framework_TestCase
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
