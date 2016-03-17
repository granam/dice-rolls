<?php
namespace Drd\Tests\DiceRoll;

use Drd\DiceRoll\DiceRoll;
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
