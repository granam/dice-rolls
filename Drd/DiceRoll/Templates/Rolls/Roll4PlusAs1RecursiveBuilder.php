<?php
namespace Drd\DiceRoll\Templates\Rolls;

use Drd\DiceRoll\DiceInterface;
use Drd\DiceRoll\RollBuilderInterface;

class Roll4PlusAs1RecursiveBuilder implements RollBuilderInterface
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
     * @return Roll4PlusAs1Recursive
     */
    public function createRoll()
    {
        return new Roll4PlusAs1Recursive($this->dice);
    }
}
