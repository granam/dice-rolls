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
     * @param int $rollSequenceStart
     * @return DiceRoll[]
     */
    public function rollDices($rollSequenceStart)
    {
        return $this->roller->roll($rollSequenceStart)->getDiceRolls();
    }

}
