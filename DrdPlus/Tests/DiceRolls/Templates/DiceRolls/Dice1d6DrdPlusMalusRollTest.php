<?php
declare(strict_types=1);

namespace DrdPlus\Tests\DiceRolls\Templates\DiceRolls;

use DrdPlus\DiceRolls\DiceRollEvaluator;
use DrdPlus\DiceRolls\Templates\Evaluators\ThreeOrLessAsMinusOneZeroOtherwiseEvaluator;

class Dice1d6DrdPlusMalusRollTest extends AbstractDice1d6RollTest
{
    protected function getDiceRollEvaluator(): DiceRollEvaluator
    {
        return ThreeOrLessAsMinusOneZeroOtherwiseEvaluator::getIt();
    }
}