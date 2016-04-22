<?php
namespace Drd\DiceRoll\Templates\Rollers;

use Drd\DiceRoll\Roller;
use Drd\DiceRoll\Templates\Numbers\One;
use Drd\DiceRoll\Templates\Dices\Dice1d6;
use Drd\DiceRoll\Templates\Evaluators\OneToOne;
use Drd\DiceRoll\Templates\RollOn\NoRollOn;

class Roller1d6 extends Roller
{
    private static $roller1d6;

    /**
     * @return Roller1d6|static
     */
    public static function getIt()
    {
        if (self::$roller1d6 === null) {
            self::$roller1d6 = new static();
        }

        return self::$roller1d6;
    }

    public function __construct()
    {
        parent::__construct(
            Dice1d6::getIt(),
            One::getIt(),
            OneToOne::getIt(),
            NoRollOn::getIt(),
            NoRollOn::getIt()
        );
    }
}
