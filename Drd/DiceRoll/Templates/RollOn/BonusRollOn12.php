<?php
namespace Drd\DiceRoll\Templates\RollOn;

use Drd\DiceRoll\AbstractRollOn;

class BonusRollOn12 extends AbstractRollOn
{

    /**
     * @param int $rolledValue
     *
     * @return bool
     */
    public function shouldHappen($rolledValue)
    {
        return intval($rolledValue) === 12;
    }

}
