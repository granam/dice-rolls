<?php
namespace Drd\DiceRoll\Templates\Numbers;

use Granam\Integer\IntegerInterface;

class Zero implements IntegerInterface
{
    /**
     * @var Zero
     */
    private static $zero;

    /**
     * @return Zero
     */
    public static function getIt()
    {
        if (self::$zero === null) {
            self::$zero = new self();
        }

        return self::$zero;
    }

    public function getValue()
    {
        return 0;
    }

    public function __toString()
    {
        return (string)$this->getValue();
    }

}