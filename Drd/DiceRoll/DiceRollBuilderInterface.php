<?php
namespace Drd\DiceRoll;

use Granam\Integer\IntegerObject;

interface DiceRollBuilderInterface
{
    /**
     * @param DiceInterface $dice
     * @param IntegerObject $rolledNumber
     * @param IntegerObject $rollSequence
     *
     * @return DiceRoll
     */
    public function create(DiceInterface $dice, IntegerObject $rolledNumber, IntegerObject $rollSequence);
}
