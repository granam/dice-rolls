<?php
namespace Drd\DiceRoll\Templates\Rolls;

use Drd\DiceRoll\RollBuilderInterface;

class Roll1d6PlusBuilder implements RollBuilderInterface {

    /**
     * @return Roll1d6Plus
     */
    public function createRoll()
    {
        return new Roll1d6Plus();
    }
}
