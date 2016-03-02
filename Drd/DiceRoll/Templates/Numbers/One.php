<?php
namespace Drd\DiceRoll\Templates\Numbers;

use Granam\Integer\IntegerInterface;

class One implements IntegerInterface
{
    /**
     * @var One
     */
    private static $one;

    /**
     * @return One
     */
    public static function getIt()
    {
        if (!isset(self::$one)) {
            self::$one = new self();
        }

        return self::$one;
    }

    private function __construct()
    {
    }

    public function getValue()
    {
        return 1;
    }

    public function __toString()
    {
        return (string)$this->getValue();
    }

}