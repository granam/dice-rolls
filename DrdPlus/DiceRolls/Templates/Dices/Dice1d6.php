<?php
declare(strict_types=1);

namespace DrdPlus\DiceRolls\Templates\Dices;

use DrdPlus\DiceRolls\Templates\Numbers\One;
use DrdPlus\DiceRolls\Templates\Numbers\Six;

class Dice1d6 extends CustomDice
{

    /**
     * @var Dice1d6|null
     */
    private static $dice1d6;

    /**
     * @return Dice1d6
     */
    public static function getIt(): Dice1d6
    {
        if (self::$dice1d6 === null) {
            self::$dice1d6 = new static();
        }

        return self::$dice1d6;
    }

    public function __construct()
    {
        parent::__construct(One::getIt(), Six::getIt());
    }
}
