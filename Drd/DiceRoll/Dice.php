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
            throw new \LogicException('Minimum ' . $minimum->getValue() . ' can not be higher then maximum' . $maximum->getValue());
        }
        if ($minimum->getValue() < 0 || $minimum->getValue() === 0) {
            throw new \LogicException('Minimum ' . $minimum->getValue() . ' has to be positive integer');
        }
        if ($maximum->getValue() < 0 || $maximum->getValue() === 0) {
            throw new \LogicException('Maximum ' . $maximum->getValue() . ' has to be positive integer');
        }
    }

    /**
     * @return StrictInteger
     */
    public function getMinimum()
    {
        $this->minimum;
    }

    /**
     * @return StrictInteger
     */
    public function getMaximum()
    {
        $this->maximum;
    }
}
