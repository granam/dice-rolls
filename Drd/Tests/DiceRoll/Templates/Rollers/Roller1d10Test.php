<?php
namespace Drd\Tests\DiceRoll\Templates\Rollers;

use Drd\DiceRoll\Templates\Dices\Dice1d10;
use Drd\DiceRoll\Templates\Evaluators\OneToOne;
use Drd\DiceRoll\Templates\Rollers\Roller1d10;
use Drd\DiceRoll\Templates\RollOn\NoRollOn;
use Granam\Integer\IntegerInterface;

/**
 * Useful for D&D
 */
class Roller1d10Test extends AbstractRollerTest
{

    /**
     * @test
     */
    public function I_can_create_it()
    {
        $roller1d10 = Roller1d10::getIt();
        $this->assertSame($roller1d10, Roller1d10::getIt());
        $this->assertInstanceOf(Dice1d10::class, $roller1d10->getDice());
        $this->assertInstanceOf(IntegerInterface::class, $roller1d10->getNumberOfStandardRolls());
        $this->assertSame(1, $roller1d10->getNumberOfStandardRolls()->getValue());
        $this->assertInstanceOf(OneToOne::class, $roller1d10->getDiceRollEvaluator());
        $this->assertInstanceOf(NoRollOn::class, $roller1d10->getBonusRollOn());
        $this->assertInstanceOf(NoRollOn::class, $roller1d10->getMalusRollOn());
    }

    /**
     * @test
     */
    public function I_can_roll_by_it()
    {
        $roller1d10 = Roller1d10::getIt();
        $previousRoll = null;
        for ($round = 1; $round < self::ROLLS_ROUNDS; $round++) {
            $roll = $roller1d10->roll();
            $this->assertNotSame($previousRoll, $roll);
            $this->assertGreaterThanOrEqual($roller1d10->getDice()->getMinimum()->getValue(), $roll->getValue());
            $this->assertLessThanOrEqual($roller1d10->getDice()->getMaximum()->getValue(), $roll->getValue());
            $previousRoll = $roll;
        }
        $this->assertEquals(new Roller1d10(), $roller1d10, 'Roller has to be stateless');
    }
}
