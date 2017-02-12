<?php
namespace Drd\DiceRolls\Templates\Rollers;

use Drd\DiceRolls\DiceRoll;
use Drd\DiceRolls\Roller;
use Drd\DiceRolls\Templates\Numbers\One;
use Drd\DiceRolls\Templates\Dices\Dice1d6;
use Drd\DiceRolls\Templates\Evaluators\OneToOneEvaluator;
use Drd\DiceRolls\Templates\RollOn\NoRollOn;
use Drd\DiceRolls\Templates\Rolls\Roll1d6;

class Roller1d6 extends Roller
{
    private static $roller1d6;

    /**
     * @return Roller1d6|static
     */
    public static function getIt()
    {
        if (self::$roller1d6 === null) {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            self::$roller1d6 = new static();
        }

        return self::$roller1d6;
    }

    /**
     * @throws \Drd\DiceRolls\Exceptions\BonusAndMalusChanceConflict
     */
    public function __construct()
    {
        parent::__construct(
            Dice1d6::getIt(),
            One::getIt(),
            OneToOneEvaluator::getIt(),
            NoRollOn::getIt(),
            NoRollOn::getIt()
        );
    }

    /**
     * @param array|DiceRoll[] $standardDiceRolls
     * @param array|DiceRoll[] $bonusDiceRolls
     * @param array|DiceRoll[] $malusDiceRolls
     * @return Roll1d6
     */
    protected function createRoll(array $standardDiceRolls, array $bonusDiceRolls, array $malusDiceRolls)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return new Roll1d6(array_shift($standardDiceRolls));
    }
}