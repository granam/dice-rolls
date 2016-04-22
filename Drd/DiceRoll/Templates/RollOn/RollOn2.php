<?php
namespace Drd\DiceRoll\Templates\RollOn;

class RollOn2 extends AbstractRollOn
{

    /**
     * @param int $rolledValue
     *
     * @return bool
     */
    public function shouldHappen($rolledValue)
    {
        return (int)$rolledValue === 2;
    }

}
