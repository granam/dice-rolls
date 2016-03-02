<?php
namespace Drd\DiceRoll;

interface RollOn
{
    /**
     * @param int $rolledValue
     *
     * @return bool
     */
    public function shouldHappen($rolledValue);

    /**
     * @return array|DiceRoll[]
     */
    public function rollDices();

}
