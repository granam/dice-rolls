<?php
namespace Drd\DiceRoll\Templates\Counts;

use Granam\Integer\IntegerInterface;

final class Zero implements IntegerInterface
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
        if (!isset(self::$zero)) {
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