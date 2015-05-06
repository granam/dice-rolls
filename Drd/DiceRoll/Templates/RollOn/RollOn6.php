<?php
namespace Drd\DiceRoll\Templates\RollOn;

use Drd\DiceRoll\AbstractRollOn;

class RollOn6 extends AbstractRollOn
{

    /**
     * @param int $rolledValue
     *
     * @return bool
     */
    public function shouldHappen($rolledValue)
    {
        return intval($rolledValue) === 6;
    }

}
