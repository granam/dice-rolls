<?php
declare(strict_types=1);

namespace DrdPlus\DiceRolls\Templates\Rollers;

use DrdPlus\DiceRolls\Roller;
use DrdPlus\DiceRolls\Templates\Numbers\One;
use DrdPlus\DiceRolls\Templates\Dices\Dice1d6;
use DrdPlus\DiceRolls\Templates\Evaluators\OneToOneEvaluator;
use DrdPlus\DiceRolls\Templates\RollOn\RollOn6;
use DrdPlus\DiceRolls\Templates\RollOn\NoRollOn;

class Roller1d6Plus extends Roller
{
    /**
     * @var Roller1d6Plus
     */
    private static $roller1d6Plus;

    /**
     * @return Roller1d6Plus
     * @throws \DrdPlus\DiceRolls\Exceptions\InvalidDiceRange
     * @throws \DrdPlus\DiceRolls\Exceptions\InvalidNumberOfRolls
     * @throws \DrdPlus\DiceRolls\Exceptions\BonusAndMalusChanceConflict
     */
    public static function getIt(): Roller1d6Plus
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