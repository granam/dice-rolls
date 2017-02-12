<?php
namespace Drd\DiceRolls\Templates\Rollers;

use Drd\DiceRolls\Roller;
use Drd\DiceRolls\Templates\Numbers\One;
use Drd\DiceRolls\Templates\Dices\Dice1d6;
use Drd\DiceRolls\Templates\Evaluators\OneToOneEvaluator;
use Drd\DiceRolls\Templates\RollOn\RollOn6;
use Drd\DiceRolls\Templates\RollOn\NoRollOn;

class Roller1d6Plus extends Roller
{
    private static $roller1d6Plus;

    /**
     * @return Roller1d6Plus|static
     */
    public static function getIt()
    {
        if (self::$roller1d6Plus === null) {
            self::$roller1d6Plus = new static();
        }

        return self::$roller1d6Plus;
    }

    public function __construct()
    {
        parent::__construct(
            Dice1d6::getIt(),
            One::getIt(),
            OneToOneEvaluator::getIt(),
            new RollOn6($this), // on 6 roll again
            NoRollOn::getIt() // no malus
        );
    }
}