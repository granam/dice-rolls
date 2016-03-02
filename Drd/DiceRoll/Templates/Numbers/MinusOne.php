<?php
namespace Drd\DiceRoll\Templates\Numbers;

use Granam\Integer\IntegerInterface;

class MinusOne implements IntegerInterface
{
    /**
     * @var MinusOne
     */
    private static $minusOne;

    /**
     * @return One
     */
    public static function getIt()
    {
        if (!isset(self::$minusOne)) {
            self::$minusOne = new self();
        }

        return self::$minusOne;
    }

    private function __construct()
    {
    }

    public function getValue()
    {
        return -1;
    }

    public function __toString()
    {
        return (string)$this->getValue();
    }

}