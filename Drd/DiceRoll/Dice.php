<?php
namespace Drd\DiceRoll;

use Granam\Integer\IntegerInterface;
use Granam\Strict\Object\StrictObject;

class Dice extends StrictObject implements DiceInterface
{

    /**
     * @var IntegerInterface
     */
    private $minimum;
    /**
     * @var IntegerInterface
     */
    private $maximum;

    /**
     * @param IntegerInterface $minimum
     * @param IntegerInterface $maximum
     */
    public function __construct(IntegerInterface $minimum, IntegerInterface $maximum)
    {
        $this->checkRange($minimum, $maximum);
        $this->minimum = $minimum;
        $this->maximum = $maximum;
    }

    private function checkRange(IntegerInterface $minimum, IntegerInterface $maximum)
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
     * @return IntegerInterface
     */
    public function getMinimum()
    {
        return $this->minimum;
    }

    /**
     * @return IntegerInterface
     */
    public function getMaximum()
    {
        return $this->maximum;
    }
}
