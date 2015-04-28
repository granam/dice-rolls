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

    public function __construct(RollBuilderInterface $rollFactory)
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
            $this->roll = $this->rollFactory->createRoll();
        }

        return $this->roll;
    }

}
