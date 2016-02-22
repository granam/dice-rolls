<?php
namespace Drd\DiceRoll\Templates\Dices;

use Drd\DiceRoll\Dice;
use Drd\DiceRoll\Templates\Counts\One;
use Drd\DiceRoll\Templates\Counts\Six;

class Dice1d6 extends Dice {

    public function __construct()
    {
        parent::__construct(One::getIt(), Six::getIt());
    }
}
