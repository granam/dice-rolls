<?php
declare(strict_types=1);

namespace DrdPlus\DiceRolls\Templates\Rollers;

use DrdPlus\DiceRolls\Roller;
use DrdPlus\DiceRolls\Templates\Numbers\One;
use DrdPlus\DiceRolls\Templates\Dices\Dice1d4;
use DrdPlus\DiceRolls\Templates\Evaluators\OneToOneEvaluator;
use DrdPlus\DiceRolls\Templates\RollOn\NoRollOn;

/**
 * Useful for D&D
 */
class Roller1d4 extends Roller
{
    private static $roller1d4;

    /**
     * @return Roller1d4
     */
    public static function getIt(): Roller1d4
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