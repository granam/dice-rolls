<?php
namespace Drd\DiceRoll\Templates;

use Drd\DiceRoll\Roll;
use Granam\Strict\Integer\StrictInteger;

class Roll1d4 extends Roll
{
    public function __construct()
    {
        $noRollOn = new NoRollOn();
        parent::__construct(
            new Dice1d4(),
            new StrictInteger(1),
            $noRollOn,
            $noRollOn
        );
    }
}
