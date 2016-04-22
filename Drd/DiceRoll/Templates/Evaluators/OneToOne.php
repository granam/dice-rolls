<?php
namespace Drd\DiceRoll\Templates\Evaluators;

use Drd\DiceRoll\DiceRoll;
use Drd\DiceRoll\DiceRollEvaluator;
use Granam\Integer\IntegerObject;
use Granam\Strict\Object\StrictObject;

class OneToOne extends StrictObject implements DiceRollEvaluator
{

    /**
     * @var OneToOne|null
     */
    private static $oneToOne;

    /**
     * @return OneToOne
     */
    public static function getIt()
    {
        if (self::$oneToOne === null) {
            self::$oneToOne = new static();
        }

        return self::$oneToOne;
    }

    /**
     * @param DiceRoll $diceRoll
     * @return IntegerObject
     */
    public function evaluateDiceRoll(DiceRoll $diceRoll)
    {
        return $diceRoll->getRolledNumber();
    }
}
