<?php
namespace Drd\DiceRoll\Templates\Dices;

use Drd\DiceRoll\Dice;
use Drd\DiceRoll\Templates\Counts\Four;
use Drd\DiceRoll\Templates\Counts\One;

class Dice1d4 extends Dice {

    public function __construct()
    {
        parent::__construct(One::getIt(), Four::getIt());
    }
}
