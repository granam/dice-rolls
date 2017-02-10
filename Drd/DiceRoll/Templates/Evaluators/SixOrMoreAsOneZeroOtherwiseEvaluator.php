<?php
namespace Drd\DiceRoll\Templates\Evaluators;

use Drd\DiceRoll\DiceRoll;
use Drd\DiceRoll\DiceRollEvaluator;
use Drd\DiceRoll\Templates\Numbers\One;
use Drd\DiceRoll\Templates\Numbers\Zero;
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
     * @return \Drd\DiceRoll\Templates\Numbers\Number
     */
    public function evaluateDiceRoll(DiceRoll $diceRoll)
    {
        return $diceRoll->getRolledNumber()->getValue() >= 6
            ? One::getIt()
            : Zero::getIt();
    }
}