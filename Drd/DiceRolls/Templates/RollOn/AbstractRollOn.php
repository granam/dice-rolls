<?php
namespace Drd\DiceRolls\Templates\RollOn;

use Drd\DiceRolls\DiceRoll;
use Drd\DiceRolls\Roller;
use Drd\DiceRolls\RollOn;
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
     * @param int $sequenceNumberStart
     * @return DiceRoll[]
     */
    public function rollDices($sequenceNumberStart)
    {
        return $this->roller->roll($sequenceNumberStart)->getDiceRolls();
    }

}