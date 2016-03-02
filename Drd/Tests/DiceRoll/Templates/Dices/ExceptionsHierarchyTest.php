<?php
namespace Drd\Tests\DiceRoll\Templates\Dices;

use Drd\DiceRoll\Templates\Dices\CustomDice;

class ExceptionsHierarchyTest extends \Drd\Tests\DiceRoll\ExceptionsHierarchyTest
{
    protected function getTestedNamespace()
    {
        $reflection = new \ReflectionClass(CustomDice::class);

        return $reflection->getNamespaceName();
    }

}
