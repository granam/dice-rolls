<?php
namespace Drd\DiceRoll;

use Granam\Integer\IntegerObject;

interface DiceInterface
{
    /**
     * @return IntegerObject
     */
    public function getMinimum();

    /**
     * @return IntegerObject
     */
    public function getMaximum();
}
