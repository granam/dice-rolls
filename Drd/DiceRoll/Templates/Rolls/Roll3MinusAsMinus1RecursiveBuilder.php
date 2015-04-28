<?php
namespace Drd\DiceRoll\Templates\Rolls;

use Drd\DiceRoll\DiceInterface;
use Drd\DiceRoll\RollBuilderInterface;

class Roll3MinusAsMinus1RecursiveBuilder implements RollBuilderInterface
{
    /**
     * @var DiceInterface
     */
    private $dice;

    public function __construct(DiceInterface $dice)
    {
        $this->dice = $dice;
    }

    /**
     * @return Roll3MinusAsMinus1Recursive
     */
    public function createRoll()
    {
        return new Roll3MinusAsMinus1Recursive($this->dice);
    }
}
