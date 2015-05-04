<?php
namespace Drd\DiceRoll\Templates\Rolls\Builders;

use Drd\DiceRoll\DiceInterface;
use Drd\DiceRoll\RollBuilderInterface;
use Drd\DiceRoll\Templates\Rolls\Roll4PlusAs1Recursive;

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
