<?php
namespace Drd\DiceRolls\Templates\Rollers;

use Drd\DiceRolls\Roller;
use Drd\DiceRolls\Templates\Numbers\One;
use Drd\DiceRolls\Templates\Dices\Dice1d4;
use Drd\DiceRolls\Templates\Evaluators\OneToOneEvaluator;
use Drd\DiceRolls\Templates\RollOn\NoRollOn;

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
            OneToOneEvaluator::getIt(),
            $noRollOn,
            $noRollOn
        );
    }
}