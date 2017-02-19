<?php
namespace Drd\Tests\DiceRolls\Templates\Dices;

use Drd\DiceRolls\Templates\Dices\CustomDice;
use Drd\DiceRolls\Templates\Dices\Dice1d6;
use PHPUnit\Framework\TestCase;

abstract class AbstractPredefinedDiceTest extends TestCase
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