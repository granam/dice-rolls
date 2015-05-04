<?php
namespace Drd\DiceRoll\Templates\Rolls\Builders;

use Drd\DiceRoll\RollBuilderInterface;
use Drd\DiceRoll\Templates\Rolls\Roll1d6Plus;

class Roll1d6PlusBuilder implements RollBuilderInterface {

    /**
     * @return Roll1d6Plus
     */
    public function createRoll()
    {
        return new Roll1d6Plus();
    }
}
