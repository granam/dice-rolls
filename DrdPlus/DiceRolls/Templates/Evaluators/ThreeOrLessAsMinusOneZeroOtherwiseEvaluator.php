<?php
declare(strict_types=1);

namespace DrdPlus\DiceRolls\Templates\Evaluators;

use DrdPlus\DiceRolls\DiceRoll;
use DrdPlus\DiceRolls\DiceRollEvaluator;
use DrdPlus\DiceRolls\Templates\Numbers\MinusOne;
use DrdPlus\DiceRolls\Templates\Numbers\Zero;
use Granam\Integer\IntegerInterface;
use Granam\Strict\Object\StrictObject;

class ThreeOrLessAsMinusOneZeroOtherwiseEvaluator extends StrictObject implements DiceRollEvaluator
{
    /**
     * @var ThreeOrLessAsMinusOneZeroOtherwiseEvaluator|null
     */
    private static $threeOrLessAsMinusOneZeroOtherwiseEvaluator;

    /**
     * @return ThreeOrLessAsMinusOneZeroOtherwiseEvaluator
     */
    public static function getIt(): ThreeOrLessAsMinusOneZeroOtherwiseEvaluator
    {
        if (self::$threeOrLessAsMinusOneZeroOtherwiseEvaluator === null) {
            self::$threeOrLessAsMinusOneZeroOtherwiseEvaluator = new static();
        }

        return self::$threeOrLessAsMinusOneZeroOtherwiseEvaluator;
    }

    /**
     * @param DiceRoll $diceRoll
     * @return \DrdPlus\DiceRolls\Templates\Numbers\Number|IntegerInterface
     */
    public function evaluateDiceRoll(DiceRoll $diceRoll): IntegerInterface
    {
        return $diceRoll->getRolledNumber()->getValue() <= 3
            ? MinusOne::getIt()
            : Zero::getIt();
    }
}