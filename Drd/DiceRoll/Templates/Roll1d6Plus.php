<?php
namespace Drd\DiceRoll\Templates;

use Drd\DiceRoll\Roll;
use Granam\Strict\Integer\StrictInteger;

class Roll1d6Plus extends Roll
{
    public function __construct()
    {
        $noRollOn = new NoRollOn();
        parent::__construct(
            new Dice1d6(),
            new StrictInteger(1),
            $noRollOn, // bonus
            $noRollOn // malus
        );
    }
}
