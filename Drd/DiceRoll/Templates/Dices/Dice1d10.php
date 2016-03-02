<?php
namespace Drd\DiceRoll\Templates\Dices;

use Drd\DiceRoll\Templates\Numbers\One;
use Drd\DiceRoll\Templates\Numbers\Ten;

class Dice1d10 extends CustomDice
{
    private static $dice1d10;

    /**
     * @return Dice1d10
     */
    public static function getIt()
    {
        if (!isset(self::$dice1d10)) {
            self::$dice1d10 = new static();
        }

        return self::$dice1d10;
    }

    public function __construct()
    {
        parent::__construct(One::getIt(), Ten::getIt());
    }
}
