<?php
namespace Drd\Tests\DiceRoll\Templates\Rollers\SpecificRolls;

use Drd\DiceRoll\Roll;
use Drd\DiceRoll\Templates\Rollers\SpecificRolls\Roll2d6DrdPlus;

class Roll2d6DrdPlusTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_use_it_as_standard_roll()
    {
        self::assertInstanceOf(Roll::class, new Roll2d6DrdPlus([] ,[] ,[]));
    }
}
