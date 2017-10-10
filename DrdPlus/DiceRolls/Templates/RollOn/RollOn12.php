<?php
declare(strict_types=1);

namespace DrdPlus\DiceRolls\Templates\RollOn;

class RollOn12 extends AbstractRollOn
{

    public function shouldHappen(int $rolledValue): bool
    {
        return $rolledValue === 12;
    }

}