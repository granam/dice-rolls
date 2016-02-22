<?php
namespace Drd\DiceRoll\Templates\Dices;

use Drd\DiceRoll\Dice;
use Drd\DiceRoll\Templates\Counts\One;
use Drd\DiceRoll\Templates\Counts\Ten;

class Dice1d10 extends Dice {

    public function __construct()
    {
        parent::__construct(One::getIt(), Ten::getIt());
    }
}
