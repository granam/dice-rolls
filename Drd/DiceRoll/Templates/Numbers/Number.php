<?php
namespace Drd\DiceRoll\Templates\Numbers;

use Granam\Integer\IntegerInterface;
use Granam\Integer\Tools\ToInteger;
use Granam\Strict\Object\StrictObject;

abstract class Number extends StrictObject implements IntegerInterface
{
    /**
     * @var Number[]
     */
    private static $instances = [];

    /**
     * @param int|IntegerInterface $value
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     * @return Number
     */
    protected static function getInstance($value)
    {
        if (!array_key_exists(static::class, self::$instances)) {
            self::$instances[static::class] = new static($value);
        }

        return self::$instances[static::class];
    }
    /**
     * @var int
     */
    private $value;

    /**
     * @param int|IntegerInterface $value
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    protected function __construct($value)
    {
        $this->value = ToInteger::toInteger($value);
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->getValue();
    }
}