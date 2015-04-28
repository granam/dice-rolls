<?php
namespace Drd\DiceRoll\Templates\Dices;

use Drd\DiceRoll\Dice;
use Granam\Strict\Integer\StrictInteger;

class Dice1d10 extends Dice {

    public function __construct()
    {
        parent::__construct(new StrictInteger(1), new StrictInteger(10));
    }
}
