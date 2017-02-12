<?php
namespace Drd\DiceRolls\Templates\Dices;

use Drd\DiceRolls\Templates\Numbers\Four;
use Drd\DiceRolls\Templates\Numbers\One;

class Dice1d4 extends CustomDice
{
    private static $dice1d4;

    /**
     * @return Dice1d4
     */
    public static function getIt()
    {
        if (self::$dice1d4 === null) {
            self::$dice1d4 = new static();
        }

        return self::$dice1d4;
    }

    public function __construct()
    {
        parent::__construct(One::getIt(), Four::getIt());
    }
}
