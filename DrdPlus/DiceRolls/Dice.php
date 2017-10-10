<?php
declare(strict_types=1);

namespace DrdPlus\DiceRolls;

use Granam\Integer\IntegerInterface;

interface Dice
{
    /**
     * @return IntegerInterface
     */
    public function getMinimum(): IntegerInterface;

    /**
     * @return IntegerInterface
     */
    public function getMaximum(): IntegerInterface;
}
