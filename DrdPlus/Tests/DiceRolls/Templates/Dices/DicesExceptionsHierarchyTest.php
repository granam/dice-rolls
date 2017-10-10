<?php
declare(strict_types=1);

namespace DrdPlus\Tests\DiceRolls\Templates\Dices;

use DrdPlus\DiceRolls\Templates\Dices\CustomDice;

class DicesExceptionsHierarchyTest extends \DrdPlus\Tests\DiceRolls\DiceRollsExceptionsHierarchyTest
{
    protected function getTestedNamespace(): string
    {
        $reflection = new \ReflectionClass(CustomDice::class);

        return $reflection->getNamespaceName();
    }

}