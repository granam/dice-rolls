<?php
namespace Drd\DiceRoll\Templates;

use Drd\DiceRoll\Roll;
use Granam\Strict\Integer\StrictInteger;

class Roll2d6Plus extends Roll
{
    public function __construct()
    {
        $dice1d6 = new Dice1d6();
        $noRollOn = new NoRollOn();
        $oneBonusRollOn4Plus = new OneBonusRollOn4Plus($dice1d6);
        $oneMalusRollOn3Minus = new OneMalusRollOn3Minus($dice1d6);
        parent::__construct(
            $dice1d6,
            new StrictInteger(2), // number of rolls = 2
            new BonusRollOn12($dice1d6, $noRollOn, $oneBonusRollOn4Plus),
            new MalusRollOn2($dice1d6, $noRollOn, $oneMalusRollOn3Minus)
        );
    }
}
