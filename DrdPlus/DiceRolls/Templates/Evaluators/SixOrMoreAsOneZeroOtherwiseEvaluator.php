<?php
declare(strict_types=1);

namespace DrdPlus\DiceRolls\Templates\Evaluators;

use DrdPlus\DiceRolls\DiceRoll;
use DrdPlus\DiceRolls\DiceRollEvaluator;
use DrdPlus\DiceRolls\Templates\Numbers\One;
use DrdPlus\DiceRolls\Templates\Numbers\Zero;
use Granam\Integer\IntegerInterface;
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
    public static function getIt(): SixOrMoreAsOneZeroOtherwiseEvaluator
    {
        if (self::$sixOrMoreAsOneZeroOtherwise === null) {
            self::$sixOrMoreAsOneZeroOtherwise = new static();
        }

        return self::$sixOrMoreAsOneZeroOtherwise;
    }

    /**
     * @param DiceRoll $diceRoll
     * @return \DrdPlus\DiceRolls\Templates\Numbers\Number|IntegerInterface
     */
    public function evaluateDiceRoll(DiceRoll $diceRoll): IntegerInterface
    {
        return $diceRoll->getRolledNumber()->getValue() >= 6
            ? One::getIt()
            : Zero::getIt();
    }
}