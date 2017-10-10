<?php
declare(strict_types=1);

namespace DrdPlus\DiceRolls\Templates\Evaluators;

use DrdPlus\DiceRolls\DiceRoll;
use DrdPlus\DiceRolls\DiceRollEvaluator;
use DrdPlus\DiceRolls\Templates\Numbers\One;
use DrdPlus\DiceRolls\Templates\Numbers\Zero;
use Granam\Integer\IntegerInterface;
use Granam\Strict\Object\StrictObject;

class FourOrMoreAsOneZeroOtherwiseEvaluator extends StrictObject implements DiceRollEvaluator
{

    /** @var FourOrMoreAsOneZeroOtherwiseEvaluator|null */
    private static $fourOrMoreAsOneZeroOtherwise;

    /**
     * @return FourOrMoreAsOneZeroOtherwiseEvaluator
     */
    public static function getIt(): FourOrMoreAsOneZeroOtherwiseEvaluator
    {
        if (self::$fourOrMoreAsOneZeroOtherwise === null) {
            self::$fourOrMoreAsOneZeroOtherwise = new static();
        }

        return self::$fourOrMoreAsOneZeroOtherwise;
    }

    /**
     * @param DiceRoll $diceRoll
     * @return IntegerInterface
     */
    public function evaluateDiceRoll(DiceRoll $diceRoll): IntegerInterface
    {
        if ($diceRoll->getRolledNumber()->getValue() >= 4) {
            return One::getIt();
        }

        return Zero::getIt();
    }
}