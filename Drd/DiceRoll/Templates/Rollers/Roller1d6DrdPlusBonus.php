<?php
namespace Drd\DiceRoll\Templates\Rollers;

use Drd\DiceRoll\Roller;
use Drd\DiceRoll\Templates\Dices\Dice1d6;
use Drd\DiceRoll\Templates\Numbers\One;
use Drd\DiceRoll\Templates\Evaluators\FourOrMoreAsOneZeroOtherwise;
use Drd\DiceRoll\Templates\RollOn\RollOn4Plus;
use Drd\DiceRoll\Templates\RollOn\NoRollOn;

class Roller1d6DrdPlusBonus extends Roller
{
    private static $roller1d6DrdPlusBonus;

    /**
     * @return Roller1d6DrdPlusBonus|static
     */
    public static function getIt()
    {
        if (self::$roller1d6DrdPlusBonus === null) {
            self::$roller1d6DrdPlusBonus = new static();
        }

        return self::$roller1d6DrdPlusBonus;
    }

    public function __construct()
    {
        parent::__construct(
            Dice1d6::getIt(),
            One::getIt(), // just a single roll of the dice
            FourOrMoreAsOneZeroOtherwise::getIt(), // rolled value 4+ = +1, 3- = 0
            new RollOn4Plus( // recursion -> 4 => roll again
                $this // in case of bonus the same type of roll happens
            ),
            NoRollOn::getIt() // no malus roll
        );
    }
}