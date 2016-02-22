<?php
namespace Drd\DiceRoll\Templates\Counts;

use Granam\Integer\IntegerInterface;

final class Six implements IntegerInterface
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
        if (!isset(self::$six)) {
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