<?php
declare(strict_types=1);

namespace DrdPlus\Tests\DiceRolls\Templates\Dices;

use DrdPlus\DiceRolls\Templates\Dices\CustomDice;
use DrdPlus\DiceRolls\Templates\Dices\Dice1d6;
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