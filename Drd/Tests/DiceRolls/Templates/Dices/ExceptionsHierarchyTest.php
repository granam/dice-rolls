<?php
namespace Drd\Tests\DiceRolls\Templates\Dices;

use Drd\DiceRolls\Templates\Dices\CustomDice;

class DiceRollsExceptionsHierarchyTest extends \Drd\Tests\DiceRolls\DiceRollsExceptionsHierarchyTest
{
    protected function getTestedNamespace()
    {
        $reflection = new \ReflectionClass(CustomDice::class);

        return $reflection->getNamespaceName();
    }

}
