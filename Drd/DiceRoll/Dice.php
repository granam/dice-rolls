<?php
namespace Drd\DiceRoll;

use Granam\Integer\IntegerObject;
use Granam\Strict\Object\StrictObject;

class Dice extends StrictObject implements DiceInterface
{

    /**
     * @var IntegerObject
     */
    private $minimum;
    /**
     * @var IntegerObject
     */
    private $maximum;

    /**
     * @param IntegerObject $minimum
     * @param IntegerObject $maximum
     */
    public function __construct(IntegerObject $minimum, IntegerObject $maximum)
    {
        $this->checkRange($minimum, $maximum);
        $this->minimum = $minimum;
        $this->maximum = $maximum;
    }

    private function checkRange(IntegerObject $minimum, IntegerObject $maximum)
    {
        if ($minimum->getValue() > $maximum->getValue()) {
            throw new Exceptions\InvalidRange(
                'Minimum (given ' . $minimum->getValue() . ') can not be higher then maximum (given ' . $maximum->getValue() . ')'
            );
        }
        if ($maximum->getValue() < 0 || $maximum->getValue() === 0) {
            throw new Exceptions\InvalidRange('Maximum (given ' . $maximum->getValue() . ') has to be positive integer');
        }
        if ($minimum->getValue() < 0 || $minimum->getValue() === 0) {
            throw new Exceptions\InvalidRange('Minimum (given ' . $minimum->getValue() . ') has to be positive integer');
        }
    }

    /**
     * @return IntegerObject
     */
    public function getMinimum()
    {
        return $this->minimum;
    }

    /**
     * @return IntegerObject
     */
    public function getMaximum()
    {
        return $this->maximum;
    }
}
