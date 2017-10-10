<?php
declare(strict_types=1);

namespace DrdPlus\DiceRolls;

interface RollOn
{
    /**
     * @param int $rolledValue
     *
     * @return bool
     */
    public function shouldHappen(int $rolledValue): bool;

    /**
     * @param int $sequenceNumberStart
     * @return array|DiceRoll[]
     */
    public function rollDices(int $sequenceNumberStart): array;

}
