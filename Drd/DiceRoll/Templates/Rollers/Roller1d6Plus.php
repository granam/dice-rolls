<?php
namespace Drd\DiceRoll\Templates\Rollers;

use Drd\DiceRoll\Roller;
use Drd\DiceRoll\Templates\Numbers\One;
use Drd\DiceRoll\Templates\Dices\Dice1d6;
use Drd\DiceRoll\Templates\Evaluators\OneToOne;
use Drd\DiceRoll\Templates\RollOn\RollOn6;
use Drd\DiceRoll\Templates\RollOn\NoRollOn;

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
            OneToOne::getIt(),
            new RollOn6($this), // on 6 roll again
            NoRollOn::getIt() // no malus
        );
    }
}
