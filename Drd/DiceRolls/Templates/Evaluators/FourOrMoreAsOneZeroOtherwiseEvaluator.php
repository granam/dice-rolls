<?php
namespace Drd\DiceRolls\Templates\Evaluators;

use Drd\DiceRolls\DiceRoll;
use Drd\DiceRolls\DiceRollEvaluator;
use Drd\DiceRolls\Templates\Numbers\One;
use Drd\DiceRolls\Templates\Numbers\Zero;
use Granam\Integer\IntegerInterface;
use Granam\Strict\Object\StrictObject;

class FourOrMoreAsOneZeroOtherwiseEvaluator extends StrictObject implements DiceRollEvaluator
{

    /**
     * @var FourOrMoreAsOneZeroOtherwiseEvaluator|null
     */
    private static $fourOrMoreAsOneZeroOtherwise;

    /**
     * @return FourOrMoreAsOneZeroOtherwiseEvaluator
     */
    public static function getIt()
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
    public function evaluateDiceRoll(DiceRoll $diceRoll)
    {
        if ($diceRoll->getRolledNumber()->getValue() >= 4) {
            return One::getIt();
        }

        return Zero::getIt();
    }
}