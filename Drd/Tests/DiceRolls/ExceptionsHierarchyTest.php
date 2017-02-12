<?php
namespace Drd\Tests\DiceRolls;

use Drd\DiceRolls\DiceRoll;
use Granam\Tests\Exceptions\Tools\AbstractExceptionsHierarchyTest;

class ExceptionsHierarchyTest extends AbstractExceptionsHierarchyTest
{

    protected function getRootNamespace()
    {
        $reflection = new \ReflectionClass(DiceRoll::class);

        return $reflection->getNamespaceName();
    }

    protected function getTestedNamespace()
    {
        return $this->getRootNamespace();
    }
}