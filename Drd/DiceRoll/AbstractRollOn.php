<?php
namespace Drd\DiceRoll;

use Granam\Strict\Object\StrictObject;

abstract class AbstractRollOn extends StrictObject implements RollOnInterface
{
    /**
     * @var Roll
     */
    private $roll;

    /**
     * @var \Closure
     */
    private $rollFactory;

    public function __construct(\Closure $rollFactory)
    {
        $this->rollFactory = $rollFactory;
    }

    /**
     * @return bool
     */
    public function happened()
    {
        return isset($this->roll) && count($this->getRoll()->getLastStandardDiceRolls()) > 0;
    }


    /**
     * @return Roll
     */
    public function getRoll()
    {
        if (!$this->roll) {
            $this->roll = $this->createRoll();
        }

        return $this->roll;
    }

    /**
     * @return Roll
     */
    private function createRoll()
    {
        $rollFactory = $this->rollFactory;
        $roll = $rollFactory();
        if (!is_a($roll, Roll::class)) {
            throw new \LogicException(
                'Roll factory did not return a roll, but ' . gettype($roll)
                . is_object($roll)
                    ? '; ' . get_class($roll)
                    : ''
            );
        }

        return $roll;
    }

}
