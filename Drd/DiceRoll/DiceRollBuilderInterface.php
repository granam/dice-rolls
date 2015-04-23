<?php
namespace Drd\DiceRoll;

use Granam\Strict\Integer\StrictInteger;

interface DiceRollBuilderInterface
{
    public function create(Dice $dice, StrictInteger $rolledValue, StrictInteger $rollSequence);
}
