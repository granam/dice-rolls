<?php
declare(strict_types=1);

namespace DrdPlus\DiceRolls\Templates\Rollers;

use DrdPlus\DiceRolls\DiceRoll;
use DrdPlus\DiceRolls\Roll;
use DrdPlus\DiceRolls\Roller;
use DrdPlus\DiceRolls\Templates\Numbers\Two;
use DrdPlus\DiceRolls\Templates\Dices\Dice1d6;
use DrdPlus\DiceRolls\Templates\Evaluators\OneToOneEvaluator;
use DrdPlus\DiceRolls\Templates\Rolls\Roll2d6DrdPlus;
use DrdPlus\DiceRolls\Templates\RollOn\RollOn12;
use DrdPlus\DiceRolls\Templates\RollOn\RollOn2;

/**
 * 2x1d6; 12 = bonus roll by 1x1d6 => 1-3 = 0, 4-6 = +1 and rolls again; 2 = malus roll by 1x1d6 => 1-3 = -1 and rolls again, 4-6 = 0
 * @method Roll2d6DrdPlus|Roll roll(int $sequenceStartNumber = 1): Roll
 */
class Roller2d6DrdPlus extends Roller
{

    private static $roller2d6DrdPlus;

    /**
     * @return Roller2d6DrdPlus
     */
    public static function getIt(): Roller2d6DrdPlus
    {
        if (self::$roller2d6DrdPlus === null) {
            self::$roller2d6DrdPlus = new static();
        }

        return self::$roller2d6DrdPlus;
    }

    public function __construct()
    {
        parent::__construct(
            Dice1d6::getIt(),
            Two::getIt(), // number of rolls = 2
            OneToOneEvaluator::getIt(), // rolled value remains untouched
            new RollOn12( // bonus happens on sum roll value of 12 (both standard rolls summarized)
                Roller1d6DrdPlusBonus::getIt() // bonus roll by 1d6; 1-3 = +0; 4-6 = +1; repeatedly in case of bonus
            ),
            new RollOn2( // malus happens on sum roll of 2 (both standard rolls summarized)
                Roller1d6DrdPlusMalus::getIt() // malus roll by 1d6; 1-3 = -1; 4-6 = 0; repeatedly in case of malus
            )
        );
    }

    /**
     * @param array|DiceRoll[] $standardDiceRolls
     * @param array|DiceRoll[] $bonusDiceRolls
     * @param array|DiceRoll[] $malusDiceRolls
     * @return Roll2d6DrdPlus|Roll
     */
    protected function createRoll(array $standardDiceRolls, array $bonusDiceRolls, array $malusDiceRolls): Roll
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return new Roll2d6DrdPlus($standardDiceRolls, $bonusDiceRolls, $malusDiceRolls);
    }

}