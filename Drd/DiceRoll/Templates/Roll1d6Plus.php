<?php
namespace Drd\DiceRoll\Templates;

use Drd\DiceRoll\Roll;
use Granam\Strict\Integer\StrictInteger;

class Roll1d6Plus extends Roll
{
    public function __construct()
    {
        parent::__construct(
            new Dice1d6(),
            new StrictInteger(1),
            new SameBonusRollOn6(
                function() { // its needed for lazy loading to avoid chained instance creations
                    return new Roll1d6Plus();
                }
            ), // bonus
            new NoRollOn() // no malus
        );
    }
}
