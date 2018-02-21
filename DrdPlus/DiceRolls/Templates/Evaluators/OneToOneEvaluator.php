<?php
declare(strict_types=1);

namespace DrdPlus\DiceRolls\Templates\Evaluators;

use DrdPlus\DiceRolls\DiceRoll;
use DrdPlus\DiceRolls\DiceRollEvaluator;
use Granam\Integer\IntegerInterface;
use Granam\Strict\Object\StrictObject;

class OneToOneEvaluator extends StrictObject implements DiceRollEvaluator
{

    /** @var OneToOneEvaluator|null */
    private static $oneToOneEvaluator;

    /**
     * @return OneToOneEvaluator
     */
    public static function getIt(): OneToOneEvaluator
    {
        if (self::$oneToOneEvaluator === null) {
            self::$oneToOneEvaluator = new static();
        }

        return self::$oneToOneEvaluator;
    }

    /**
     * @param DiceRoll $diceRoll
     * @return IntegerInterface
     */
    public function evaluateDiceRoll(DiceRoll $diceRoll): IntegerInterface
    {
        return $diceRoll->getRolledNumber();
    }
}