<?php
namespace Drd\DiceRolls\Templates\Rollers;

use Drd\DiceRolls\Roller;
use Drd\DiceRolls\Templates\Numbers\One;
use Drd\DiceRolls\Templates\Dices\Dice1d6;
use Drd\DiceRolls\Templates\Evaluators\OneToOneEvaluator;
use Drd\DiceRolls\Templates\RollOn\RollOn6;
use Drd\DiceRolls\Templates\RollOn\NoRollOn;

class Roller1d6Plus extends Roller
{
    /**
     * @var Roller1d6Plus
     */
    private static $roller1d6Plus;

    /**
     * @return Roller1d6Plus|static
     * @throws \Drd\DiceRolls\Exceptions\InvalidDiceRange
     * @throws \Drd\DiceRolls\Exceptions\InvalidNumberOfRolls
     * @throws \Drd\DiceRolls\Exceptions\BonusAndMalusChanceConflict
     */
    public static function getIt()
    {
        if (self::$roller1d6Plus === null) {
            self::$roller1d6Plus = new static();
        }

        return self::$roller1d6Plus;
    }

    /**
     * @throws \Drd\DiceRolls\Exceptions\InvalidDiceRange
     * @throws \Drd\DiceRolls\Exceptions\InvalidNumberOfRolls
     * @throws \Drd\DiceRolls\Exceptions\BonusAndMalusChanceConflict
     */
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