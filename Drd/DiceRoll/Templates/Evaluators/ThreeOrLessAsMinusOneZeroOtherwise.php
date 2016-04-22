<?php
namespace Drd\DiceRoll\Templates\Evaluators;

use Drd\DiceRoll\DiceRoll;
use Drd\DiceRoll\DiceRollEvaluator;
use Drd\DiceRoll\Templates\Numbers\MinusOne;
use Drd\DiceRoll\Templates\Numbers\Zero;
use Granam\Integer\IntegerObject;
use Granam\Strict\Object\StrictObject;

class ThreeOrLessAsMinusOneZeroOtherwise extends StrictObject implements DiceRollEvaluator
{
    private static $threeOrLessAsMinusOneZeroOtherwise;

    /**
     * @return ThreeOrLessAsMinusOneZeroOtherwise
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
     * @return IntegerObject
     */
    public function evaluateDiceRoll(DiceRoll $diceRoll)
    {
        return $diceRoll->getRolledNumber()->getValue() <= 3
            ? MinusOne::getIt()
            : Zero::getIt();
    }
}
