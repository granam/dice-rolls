<?php
namespace Drd\Tests\DiceRolls\Templates\Dices;

use Drd\DiceRolls\Templates\Dices\CustomDice;

class ExceptionsHierarchyTest extends \Drd\Tests\DiceRolls\ExceptionsHierarchyTest
{
    protected function getTestedNamespace()
    {
        $reflection = new \ReflectionClass(CustomDice::class);

        return $reflection->getNamespaceName();
    }

}
