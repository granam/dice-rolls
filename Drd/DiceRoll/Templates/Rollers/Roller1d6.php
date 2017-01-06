<?php
namespace Drd\DiceRoll\Templates\Rollers;

use Drd\DiceRoll\DiceRoll;
use Drd\DiceRoll\Roller;
use Drd\DiceRoll\Templates\Numbers\One;
use Drd\DiceRoll\Templates\Dices\Dice1d6;
use Drd\DiceRoll\Templates\Evaluators\OneToOne;
use Drd\DiceRoll\Templates\RollOn\NoRollOn;
use Drd\DiceRoll\Templates\Rolls\Roll1d6;

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
     * @throws \Drd\DiceRoll\Exceptions\BonusAndMalusChanceConflict
     */
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