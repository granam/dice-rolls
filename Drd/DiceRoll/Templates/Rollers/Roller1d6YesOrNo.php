<?php
namespace Drd\DiceRoll\Templates\Rollers;

use Drd\DiceRoll\Roller;
use Drd\DiceRoll\Templates\Evaluators\FourOrMoreAsOneZeroOtherwise;
use Drd\DiceRoll\Templates\Numbers\One;
use Drd\DiceRoll\Templates\Dices\Dice1d6;
use Drd\DiceRoll\Templates\RollOn\NoRollOn;

class Roller1d6YesOrNo extends Roller
{
    private static $roller1d6YesOrNo;

    /**
     * @return Roller1d6YesOrNo|static
     */
    public static function getIt()
    {
        if (self::$roller1d6YesOrNo === null) {
            self::$roller1d6YesOrNo = new static();
        }

        return self::$roller1d6YesOrNo;
    }

    public function __construct()
    {
        parent::__construct(
            Dice1d6::getIt(), // roll with 1d6
            One::getIt(), // once
            FourOrMoreAsOneZeroOtherwise::getIt(), // roll will result into zero or one equally
            NoRollOn::getIt(), // no re roll on high number
            NoRollOn::getIt() // no re roll on low number
        );
    }
}