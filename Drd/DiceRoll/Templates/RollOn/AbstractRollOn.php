<?php
namespace Drd\DiceRoll\Templates\RollOn;

use Drd\DiceRoll\DiceRoll;
use Drd\DiceRoll\Roller;
use Drd\DiceRoll\RollOn;
use Granam\Strict\Object\StrictObject;

abstract class AbstractRollOn extends StrictObject implements RollOn
{
    /**
     * @var Roller
     */
    private $roller;

    public function __construct(Roller $roller)
    {
        $this->roller = $roller;
    }

    /**
     * @return DiceRoll[]
     */
    public function rollDices()
    {
        return $this->roller->roll()->getDiceRolls();
    }

}
