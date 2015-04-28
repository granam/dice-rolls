<?php
namespace Drd\DiceRoll;

use Granam\Strict\Integer\StrictInteger;

interface DiceRollBuilderInterface
{
    /**
     * @param DiceInterface $dice
     * @param StrictInteger $rolledValue
     * @param StrictInteger $rollSequence
     *
     * @return DiceRoll
     */
    public function create(DiceInterface $dice, StrictInteger $rolledValue, StrictInteger $rollSequence);
}
