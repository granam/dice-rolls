<?php
namespace Drd\DiceRolls\Templates\Evaluators;

use Drd\DiceRolls\DiceRoll;
use Drd\DiceRolls\DiceRollEvaluator;
use Drd\DiceRolls\Templates\Numbers\One;
use Drd\DiceRolls\Templates\Numbers\Zero;
use Granam\Strict\Object\StrictObject;

class SixOrMoreAsOneZeroOtherwiseEvaluator extends StrictObject implements DiceRollEvaluator
{
    /**
     * @var SixOrMoreAsOneZeroOtherwiseEvaluator
     */
    private static $sixOrMoreAsOneZeroOtherwise;

    /**
     * @return SixOrMoreAsOneZeroOtherwiseEvaluator
     */
    public static function getIt()
    {
        if (self::$sixOrMoreAsOneZeroOtherwise === null) {
            self::$sixOrMoreAsOneZeroOtherwise = new static();
        }

        return self::$sixOrMoreAsOneZeroOtherwise;
    }

    /**
     * @param DiceRoll $diceRoll
     * @return \Drd\DiceRolls\Templates\Numbers\Number
     */
    public function evaluateDiceRoll(DiceRoll $diceRoll)
    {
        return $diceRoll->getRolledNumber()->getValue() >= 6
            ? One::getIt()
            : Zero::getIt();
    }
}