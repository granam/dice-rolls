<?php
namespace Drd\DiceRoll\Templates\Rolls;

use Drd\DiceRoll\DiceInterface;
use Drd\DiceRoll\RollBuilderInterface;

class Roll6PlusAs1RecursiveBuilder implements RollBuilderInterface
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
     * @return Roll6PlusAs1Recursive
     */
    public function createRoll()
    {
        return new Roll6PlusAs1Recursive($this->dice);
    }
}
