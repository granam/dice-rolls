<?php
namespace Drd\DiceRoll\Templates\RollOn;

class RollOn12 extends AbstractRollOn
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
