<?php
namespace Drd\DiceRolls\Templates\Rollers;

use Drd\DiceRolls\Roller;
use Drd\DiceRolls\Templates\Numbers\One;
use Drd\DiceRolls\Templates\Dices\Dice1d10;
use Drd\DiceRolls\Templates\Evaluators\OneToOneEvaluator;
use Drd\DiceRolls\Templates\RollOn\NoRollOn;

/**
 * Useful for D&D
 */
class Roller1d10 extends Roller
{
    private static $roller1d10;

    /**
     * @return Roller1d10|static
     */
    public static function getIt()
    {
        if (self::$roller1d10 === null) {
            self::$roller1d10 = new static();
        }

        return self::$roller1d10;
    }

    public function __construct()
    {
        parent::__construct(
            Dice1d10::getIt(),
            One::getIt(),
            OneToOneEvaluator::getIt(),
            NoRollOn::getIt(),
            NoRollOn::getIt()
        );
    }
}