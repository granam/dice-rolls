<?php
namespace Drd\DiceRolls\Templates\Evaluators;

use Drd\DiceRolls\DiceRoll;
use Drd\DiceRolls\DiceRollEvaluator;
use Granam\Integer\IntegerInterface;
use Granam\Strict\Object\StrictObject;

class OneToOneEvaluator extends StrictObject implements DiceRollEvaluator
{

    /**
     * @var OneToOneEvaluator|null
     */
    private static $oneToOne;

    /**
     * @return OneToOneEvaluator
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
     * @return IntegerInterface
     */
    public function evaluateDiceRoll(DiceRoll $diceRoll)
    {
        return $diceRoll->getRolledNumber();
    }
}