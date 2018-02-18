<?php
declare(strict_types=1);

namespace DrdPlus\Tests\DiceRolls\Templates\DiceRolls;

use DrdPlus\DiceRolls\DiceRollEvaluator;
use DrdPlus\DiceRolls\Templates\Evaluators\FourOrMoreAsOneZeroOtherwiseEvaluator;
use DrdPlus\DiceRolls\Templates\Evaluators\OneToOneEvaluator;

class Dice1d6DrdPlusBonusRollTest extends AbstractDice1d6RollTest
{
    protected function getDiceRollEvaluator(): DiceRollEvaluator
    {
        return FourOrMoreAsOneZeroOtherwiseEvaluator::getIt();
    }
}