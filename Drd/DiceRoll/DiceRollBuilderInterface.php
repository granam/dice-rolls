<?php
namespace Drd\DiceRoll;

use Granam\Integer\IntegerInterface;

interface DiceRollBuilderInterface
{
    /**
     * @param DiceInterface $dice
     * @param IntegerInterface $rolledNumber
     * @param IntegerInterface $rollSequence
     *
     * @return DiceRoll
     */
    public function create(DiceInterface $dice, IntegerInterface $rolledNumber, IntegerInterface $rollSequence);
}
