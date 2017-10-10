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
    private static $oneToOne;

    /**
     * @return OneToOneEvaluator
     */
    public static function getIt(): OneToOneEvaluator
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
    public function evaluateDiceRoll(DiceRoll $diceRoll): IntegerInterface
    {
        return $diceRoll->getRolledNumber();
    }
}