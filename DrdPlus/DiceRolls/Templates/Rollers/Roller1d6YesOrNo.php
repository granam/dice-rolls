<?php
declare(strict_types=1);

namespace DrdPlus\DiceRolls\Templates\Rollers;

use DrdPlus\DiceRolls\Roller;
use DrdPlus\DiceRolls\Templates\Evaluators\FourOrMoreAsOneZeroOtherwiseEvaluator;
use DrdPlus\DiceRolls\Templates\Numbers\One;
use DrdPlus\DiceRolls\Templates\Dices\Dice1d6;
use DrdPlus\DiceRolls\Templates\RollOn\NoRollOn;

class Roller1d6YesOrNo extends Roller
{
    private static $roller1d6YesOrNo;

    /**
     * @return Roller1d6YesOrNo
     */
    public static function getIt(): Roller1d6YesOrNo
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
            FourOrMoreAsOneZeroOtherwiseEvaluator::getIt(), // roll will result into zero or one equally
            NoRollOn::getIt(), // no re roll on high number
            NoRollOn::getIt() // no re roll on low number
        );
    }
}