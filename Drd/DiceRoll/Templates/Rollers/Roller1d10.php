<?php
namespace Drd\DiceRoll\Templates\Rollers;

use Drd\DiceRoll\Roller;
use Drd\DiceRoll\Templates\Numbers\One;
use Drd\DiceRoll\Templates\Dices\Dice1d10;
use Drd\DiceRoll\Templates\Evaluators\OneToOne;
use Drd\DiceRoll\Templates\RollOn\NoRollOn;

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
            OneToOne::getIt(),
            NoRollOn::getIt(),
            NoRollOn::getIt()
        );
    }
}