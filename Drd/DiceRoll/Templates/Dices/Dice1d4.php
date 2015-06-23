<?php
namespace Drd\DiceRoll\Templates\Dices;

use Drd\DiceRoll\Dice;
use Granam\Integer\IntegerObject;

class Dice1d4 extends Dice {

    public function __construct()
    {
        parent::__construct(new IntegerObject(1), new IntegerObject(4));
    }
}
