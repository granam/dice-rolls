<?php
declare(strict_types=1);

namespace DrdPlus\DiceRolls\Templates\Rollers;

use DrdPlus\DiceRolls\Roller;
use DrdPlus\DiceRolls\Templates\Dices\Dice1d6;
use DrdPlus\DiceRolls\Templates\Numbers\One;
use DrdPlus\DiceRolls\Templates\Evaluators\ThreeOrLessAsMinusOneZeroOtherwiseEvaluator;
use DrdPlus\DiceRolls\Templates\RollOn\RollOn3Minus;
use DrdPlus\DiceRolls\Templates\RollOn\NoRollOn;

class Roller1d6DrdPlusMalus extends Roller
{
    private static $roller1d6DrdPlusMalus;

    /**
     * @return Roller1d6DrdPlusMalus
     */
    public static function getIt(): Roller1d6DrdPlusMalus
    {
        if (self::$roller1d6DrdPlusMalus === null) {
            self::$roller1d6DrdPlusMalus = new static();
        }

        return self::$roller1d6DrdPlusMalus;
    }

    public function __construct()
    {
        parent::__construct(
            Dice1d6::getIt(),
            One::getIt(), // just a single roll of the dice
            ThreeOrLessAsMinusOneZeroOtherwiseEvaluator::getIt(), // value of 1-3 is turned into malus -1, higher values to 0
            NoRollOn::getIt(), // no bonus roll
            new RollOn3Minus( // in case of malus (-1) rolling continues, otherwise stops
                $this // in case of bonus the same type of roll happens
            )
        );
    }
}