<?php
namespace Drd\DiceRoll\Templates\Numbers;

use Granam\Integer\IntegerInterface;

class Six implements IntegerInterface
{
    /**
     * @var Six
     */
    private static $six;

    /**
     * @return Six
     */
    public static function getIt()
    {
        if (self::$six === null) {
            self::$six = new self();
        }

        return self::$six;
    }

    private function __construct()
    {
    }

    public function getValue()
    {
        return 6;
    }

    public function __toString()
    {
        return (string)$this->getValue();
    }

}