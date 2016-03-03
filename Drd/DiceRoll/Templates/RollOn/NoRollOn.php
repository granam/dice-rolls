<?php
namespace Drd\DiceRoll\Templates\RollOn;

use Drd\DiceRoll\DiceRoll;
use Drd\DiceRoll\RollOn;

class NoRollOn implements RollOn
{
    private static $noRollOn;

    /**
     * @return NoRollOn
     */
    public static function getIt()
    {
        if (!isset(self::$noRollOn)) {
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
