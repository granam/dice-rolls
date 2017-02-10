<?php
namespace Drd\DiceRoll\Templates\Rollers;

use Drd\DiceRoll\Roller;
use Drd\DiceRoll\Templates\Dices\Dice1d6;
use Drd\DiceRoll\Templates\Numbers\One;
use Drd\DiceRoll\Templates\Evaluators\ThreeOrLessAsMinusOneZeroOtherwiseEvaluator;
use Drd\DiceRoll\Templates\RollOn\RollOn3Minus;
use Drd\DiceRoll\Templates\RollOn\NoRollOn;

class Roller1d6DrdPlusMalus extends Roller
{
    private static $roller1d6DrdPlusMalus;

    /**
     * @return Roller1d6DrdPlusMalus|static
     */
    public static function getIt()
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