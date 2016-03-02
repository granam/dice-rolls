<?php
namespace Drd\DiceRoll\Templates\Dices;

use Drd\DiceRoll\Templates\Numbers\One;
use Drd\DiceRoll\Templates\Numbers\Six;

class Dice1d6 extends CustomDice
{

    /**
     * @var Dice1d6|null
     */
    private static $dice1d6;

    /**
     * @return Dice1d6
     */
    public static function getIt()
    {
        if (!isset(self::$dice1d6)) {
            self::$dice1d6 = new static();
        }

        return self::$dice1d6;
    }

    public function __construct()
    {
        parent::__construct(One::getIt(), Six::getIt());
    }
}
