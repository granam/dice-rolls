<?php
namespace Drd\DiceRoll\Templates\Numbers;

use Granam\Integer\IntegerInterface;

class Ten implements IntegerInterface
{
    /**
     * @var Ten
     */
    private static $ten;

    /**
     * @return Ten
     */
    public static function getIt()
    {
        if (!isset(self::$ten)) {
            self::$ten = new self();
        }

        return self::$ten;
    }

    private function __construct()
    {
    }

    public function getValue()
    {
        return 10;
    }

    public function __toString()
    {
        return (string)$this->getValue();
    }

}