<?php
namespace Drd\DiceRolls\Templates\RollOn;

use Drd\DiceRolls\DiceRoll;
use Drd\DiceRolls\RollOn;

class NoRollOn implements RollOn
{
    private static $noRollOn;

    /**
     * @return NoRollOn
     */
    public static function getIt()
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
    public function shouldHappen($rolledValue)
    {
        return false;
    }

    /**
     * @param int $sequenceNumberStart
     * @return array|DiceRoll[]
     */
    public function rollDices($sequenceNumberStart)
    {
        return [];
    }

}