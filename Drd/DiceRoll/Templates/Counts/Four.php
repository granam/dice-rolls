<?php
namespace Drd\DiceRoll\Templates\Counts;

use Granam\Integer\IntegerInterface;

final class Four implements IntegerInterface
{
    /**
     * @var Four
     */
    private static $four;

    /**
     * @return One
     */
    public static function getIt()
    {
        if (!isset(self::$four)) {
            self::$four = new self();
        }

        return self::$four;
    }

    private function __construct()
    {
    }

    public function getValue()
    {
        return 4;
    }

    public function __toString()
    {
        return (string)$this->getValue();
    }

}