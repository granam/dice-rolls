<?php
namespace Drd\DiceRoll\Templates;

use Drd\DiceRoll\Roll;
use Granam\Strict\Integer\StrictInteger;

class Roll1d6 extends Roll
{
    public function __construct()
    {
        $noRollOn = new NoRollOn();
        parent::__construct(
            new Dice1d6(),
            new StrictInteger(1),
            $noRollOn,
            $noRollOn
        );
    }
}
