<?php
namespace Drd\DiceRoll;

use Granam\Integer\IntegerInterface;

interface DiceInterface
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
