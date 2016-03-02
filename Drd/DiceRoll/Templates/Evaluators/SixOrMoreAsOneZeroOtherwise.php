<?php
namespace Drd\DiceRoll\Templates\Evaluators;

use Drd\DiceRoll\DiceRoll;
use Drd\DiceRoll\DiceRollEvaluator;
use Drd\DiceRoll\Templates\Numbers\One;
use Drd\DiceRoll\Templates\Numbers\Zero;
use Granam\Integer\IntegerObject;
use Granam\Strict\Object\StrictObject;

class SixOrMoreAsOneZeroOtherwise extends StrictObject implements DiceRollEvaluator
{
    /**
     * @var SixOrMoreAsOneZeroOtherwise
     */
    private static $sixOrMoreAsOneZeroOtherwise;

    public static function getIt()
    {
        if (!isset(self::$sixOrMoreAsOneZeroOtherwise)) {
            self::$sixOrMoreAsOneZeroOtherwise = new static();
        }

        return self::$sixOrMoreAsOneZeroOtherwise;
    }

    /**
     * @param DiceRoll $diceRoll
     * @return IntegerObject
     */
    public function evaluateDiceRoll(DiceRoll $diceRoll)
    {
        return $diceRoll->getRolledNumber()->getValue() >= 6
            ? One::getIt()
            : Zero::getIt();
    }
}
