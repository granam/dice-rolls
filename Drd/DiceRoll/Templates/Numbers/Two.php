<?php
namespace Drd\DiceRoll\Templates\Numbers;

use Granam\Integer\IntegerInterface;

class Two implements IntegerInterface
{
    /**
     * @var Two
     */
    private static $two;

    /**
     * @return One
     */
    public static function getIt()
    {
        if (!isset(self::$two)) {
            self::$two = new self();
        }

        return self::$two;
    }

    private function __construct()
    {
    }

    public function getValue()
    {
        return 2;
    }

    public function __toString()
    {
        return (string)$this->getValue();
    }

}