<?php
namespace Drd\DiceRoll\Templates\Evaluators;

use Drd\DiceRoll\DiceRoll;
use Drd\DiceRoll\DiceRollEvaluator;
use Drd\DiceRoll\Templates\Numbers\One;
use Drd\DiceRoll\Templates\Numbers\Zero;
use Granam\Integer\IntegerObject;
use Granam\Strict\Object\StrictObject;

class FourOrMoreAsOneZeroOtherwise extends StrictObject implements DiceRollEvaluator
{

    /**
     * @var FourOrMoreAsOneZeroOtherwise|null
     */
    private static $fourOrMoreAsOneZeroOtherwise;

    /**
     * @return FourOrMoreAsOneZeroOtherwise
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
     * @return IntegerObject
     */
    public function evaluateDiceRoll(DiceRoll $diceRoll)
    {
        return $diceRoll->getRolledNumber()->getValue() >= 4
            ? One::getIt()
            : Zero::getIt();
    }
}
