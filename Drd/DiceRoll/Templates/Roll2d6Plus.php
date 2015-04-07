<?php
namespace Drd\DiceRoll\Templates;

use Drd\DiceRoll\Dice;
use Drd\DiceRoll\Roll;
use Granam\Strict\Integer\StrictInteger;

class Roll2d6Plus extends Roll
{
    public function __construct()
    {
        parent::__construct(
            new Dice(new StrictInteger(1), new StrictInteger(6)),
            new StrictInteger(2),
            new StrictInteger(6)
        );
    }
}
