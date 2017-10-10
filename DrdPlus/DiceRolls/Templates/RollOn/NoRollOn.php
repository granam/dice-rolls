<?php
declare(strict_types=1);

namespace DrdPlus\DiceRolls\Templates\RollOn;

use DrdPlus\DiceRolls\DiceRoll;
use DrdPlus\DiceRolls\RollOn;

class NoRollOn implements RollOn
{
    private static $noRollOn;

    /**
     * @return NoRollOn
     */
    public static function getIt(): NoRollOn
    {
        if (self::$noRollOn === null) {
            self::$noRollOn = new static();
        }

        return self::$noRollOn;
    }

    /**
     * @param int $rolledValue
     *
     * @return bool
     */
    public function shouldHappen(int $rolledValue): bool
    {
        return false;
    }

    /**
     * @param int $sequenceNumberStart
     * @return array|DiceRoll[]
     */
    public function rollDices(int $sequenceNumberStart): array
    {
        return [];
    }

}