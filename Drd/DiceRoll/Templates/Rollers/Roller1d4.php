<?php
namespace Drd\DiceRoll\Templates\Rollers;

use Drd\DiceRoll\Roller;
use Drd\DiceRoll\Templates\Numbers\One;
use Drd\DiceRoll\Templates\Dices\Dice1d4;
use Drd\DiceRoll\Templates\Evaluators\OneToOne;
use Drd\DiceRoll\Templates\RollOn\NoRollOn;

/**
 * Useful for D&D
 */
class Roller1d4 extends Roller
{
    private static $roller1d4;

    /**
     * @return Roller1d4|static
     */
    public static function getIt()
    {
        if (self::$roller1d4 === null) {
            self::$roller1d4 = new static();
        }

        return self::$roller1d4;
    }

    public function __construct()
    {
        $noRollOn = new NoRollOn();
        parent::__construct(
            new Dice1d4(),
            One::getIt(),
            OneToOne::getIt(),
            $noRollOn,
            $noRollOn
        );
    }
}