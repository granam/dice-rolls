<?php
namespace Drd\DiceRoll;

use Granam\Strict\Integer\StrictInteger;

interface DiceInterface
{
    /**
     * @return StrictInteger
     */
    public function getMinimum();

    /**
     * @return StrictInteger
     */
    public function getMaximum();
}
