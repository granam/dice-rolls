<?php
namespace Drd\Tests\DiceRoll\Templates\Dices;

use Drd\DiceRoll\Templates\Dices\CustomDice;
use Drd\DiceRoll\Templates\Dices\Dice1d6;

abstract class AbstractPredefinedDiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_create_it()
    {
        $diceClass = $this->getDiceClass();
        $dice = $diceClass::getIt();
        self::assertSame($dice, $diceClass::getIt());
        self::assertEquals($dice, new $diceClass);
    }

    /**
     * @return string|CustomDice|Dice1d6 ...
     */
    protected function getDiceClass()
    {
        return preg_replace('~(?:[\\\]Tests)?([\\\].+)Test$~', '$1', static::class);
    }
}