<?php
namespace Drd\DiceRoll\Templates\Rolls\Builders;

use Drd\DiceRoll\DiceInterface;
use Drd\DiceRoll\RollBuilderInterface;
use Drd\DiceRoll\Templates\Rolls\Roll6PlusAs1;

class Roll6PlusAs1Builder implements RollBuilderInterface
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
     * @return Roll6PlusAs1
     */
    public function createRoll()
    {
        return new Roll6PlusAs1($this->dice);
    }
}
