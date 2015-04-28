<?php
namespace Drd\DiceRoll;

interface RollBuilderInterface
{
    /**
     * @return Roll
     */
    public function createRoll();
}
