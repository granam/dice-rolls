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
     * @param int $sequenceNumberStart
     * @return array|DiceRoll[]
     */
    public function rollDices($sequenceNumberStart);

}
