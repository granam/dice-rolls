<?php
namespace Drd\DiceRolls\Templates\Evaluators;

use Drd\DiceRolls\DiceRoll;
use Drd\DiceRolls\DiceRollEvaluator;
use Drd\DiceRolls\Templates\Numbers\MinusOne;
use Drd\DiceRolls\Templates\Numbers\Zero;
use Granam\Strict\Object\StrictObject;

class ThreeOrLessAsMinusOneZeroOtherwiseEvaluator extends StrictObject implements DiceRollEvaluator
{
    private static $threeOrLessAsMinusOneZeroOtherwise;

    /**
     * @return ThreeOrLessAsMinusOneZeroOtherwiseEvaluator
     */
    public static function getIt()
    {
        if (self::$threeOrLessAsMinusOneZeroOtherwise === null) {
            self::$threeOrLessAsMinusOneZeroOtherwise = new static();
        }

        return self::$threeOrLessAsMinusOneZeroOtherwise;
    }

    /**
     * @param DiceRoll $diceRoll
     * @return \Drd\DiceRolls\Templates\Numbers\Number
     */
    public function evaluateDiceRoll(DiceRoll $diceRoll)
    {
        return $diceRoll->getRolledNumber()->getValue() <= 3
            ? MinusOne::getIt()
            : Zero::getIt();
    }
}