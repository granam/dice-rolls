<?php
namespace Drd\DiceRoll;

use Granam\Strict\Integer\StrictInteger;
use Granam\Strict\Object\StrictObject;

class Dice extends StrictObject
{

    /**
     * @var StrictInteger
     */
    private $minimum;
    /**
     * @var StrictInteger
     */
    private $maximum;

    /**
     * @param StrictInteger $minimum
     * @param StrictInteger $maximum
     */
    public function __construct(StrictInteger $minimum, StrictInteger $maximum)
    {
        $this->checkRange($minimum, $maximum);
        $this->minimum = $minimum;
        $this->maximum = $maximum;
    }

    private function checkRange(StrictInteger $minimum, StrictInteger $maximum)
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
     * @return StrictInteger
     */
    public function getMinimum()
    {
        return $this->minimum;
    }

    /**
     * @return StrictInteger
     */
    public function getMaximum()
    {
        return $this->maximum;
    }
}
