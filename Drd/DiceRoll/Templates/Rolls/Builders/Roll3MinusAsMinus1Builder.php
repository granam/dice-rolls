<?php
namespace Drd\DiceRoll\Templates\Rolls\Builders;

use Drd\DiceRoll\DiceInterface;
use Drd\DiceRoll\RollBuilderInterface;
use Drd\DiceRoll\Templates\Rolls\Roll3MinusAsMinus1;

class Roll3MinusAsMinus1Builder implements RollBuilderInterface
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
     * @return Roll3MinusAsMinus1
     */
    public function createRoll()
    {
        return new Roll3MinusAsMinus1($this->dice);
    }
}
