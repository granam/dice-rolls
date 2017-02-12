<?php
namespace Drd\DiceRolls\Templates\RollOn;

class RollOn4Plus extends AbstractRollOn
{

    /**
     * @param int $rolledValue
     *
     * @return bool
     */
    public function shouldHappen($rolledValue)
    {
        return (int)$rolledValue >= 4;
    }

}