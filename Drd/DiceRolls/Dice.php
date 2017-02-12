<?php
namespace Drd\DiceRolls;

use Granam\Integer\IntegerInterface;

interface Dice
{
    /**
     * @return IntegerInterface
     */
    public function getMinimum();

    /**
     * @return IntegerInterface
     */
    public function getMaximum();
}
