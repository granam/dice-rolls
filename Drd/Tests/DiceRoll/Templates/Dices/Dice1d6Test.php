<?php
namespace Drd\Tests\DiceRoll\Templates\Dices;

use Drd\DiceRoll\Templates\Dices\Dice1d6;

class Dice1d6Test extends AbstractPredefinedDiceTest
{

    /**
     * @test
     */
    public function I_got_one_as_minimum()
    {
        $dice = new Dice1d6();
        self::assertSame(1, $dice->getMinimum()->getValue());
    }

    /**
     * @test
     */
    public function I_got_six_as_maximum()
    {
        $dice = new Dice1d6();
        self::assertSame(6, $dice->getMaximum()->getValue());
    }
}
