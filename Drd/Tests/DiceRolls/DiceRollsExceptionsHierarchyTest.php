<?php
namespace Drd\Tests\DiceRolls;

use Drd\DiceRolls\DiceRoll;
use Granam\Tests\ExceptionsHierarchy\Exceptions\AbstractExceptionsHierarchyTest;

class DiceRollsExceptionsHierarchyTest extends AbstractExceptionsHierarchyTest
{
    /**
     * @return string
     */
    protected function getRootNamespace()
    {
        $reflection = new \ReflectionClass(DiceRoll::class);

        return $reflection->getNamespaceName();
    }

    /**
     * @return string
     */
    protected function getTestedNamespace()
    {
        return $this->getRootNamespace();
    }
}