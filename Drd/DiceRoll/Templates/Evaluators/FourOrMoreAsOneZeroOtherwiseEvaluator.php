<?php
namespace Drd\DiceRoll\Templates\Evaluators;

use Drd\DiceRoll\DiceRoll;
use Drd\DiceRoll\DiceRollEvaluator;
use Drd\DiceRoll\Templates\Numbers\One;
use Drd\DiceRoll\Templates\Numbers\Zero;
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