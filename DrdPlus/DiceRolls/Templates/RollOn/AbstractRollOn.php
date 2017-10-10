<?php
declare(strict_types=1);

namespace DrdPlus\DiceRolls\Templates\RollOn;

use DrdPlus\DiceRolls\DiceRoll;
use DrdPlus\DiceRolls\Roller;
use DrdPlus\DiceRolls\RollOn;
use Granam\Strict\Object\StrictObject;

abstract class AbstractRollOn extends StrictObject implements RollOn
{
    /** @var Roller */
    private $roller;

    public function __construct(Roller $roller)
    {
        $this->roller = $roller;
    }

    /**
     * @param int $sequenceNumberStart
     * @return DiceRoll[]
     */
    public function rollDices(int $sequenceNumberStart): array
    {
        return $this->roller->roll($sequenceNumberStart)->getDiceRolls();
    }

}