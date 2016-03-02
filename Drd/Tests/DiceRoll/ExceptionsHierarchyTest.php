<?php
namespace Drd\Tests\DiceRoll;

use Drd\DiceRoll\DiceRoll;
use Granam\Exceptions\Tests\Tools\AbstractTestOfExceptionsHierarchy;

class ExceptionsHierarchyTest extends AbstractTestOfExceptionsHierarchy
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
