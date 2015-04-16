<?php
namespace Drd\DiceRoll\Templates;

use Drd\DiceRoll\Roll;
use Granam\Strict\Integer\StrictInteger;

class Roll1d10 extends Roll
{
    public function __construct()
    {
        $noRollOn = new NoRollOn();
        parent::__construct(
            new Dice1d10(),
            new StrictInteger(1),
            $noRollOn,
            $noRollOn
        );
    }
}
