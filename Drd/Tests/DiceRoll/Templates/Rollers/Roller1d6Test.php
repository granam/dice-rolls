<?php
namespace Drd\Tests\DiceRoll\Templates\Rollers;

use Drd\DiceRoll\Templates\Dices\Dice1d6;
use Drd\DiceRoll\Templates\Evaluators\OneToOne;
use Drd\DiceRoll\Templates\Rollers\Roller1d6;
use Drd\DiceRoll\Templates\RollOn\NoRollOn;
use Granam\Integer\IntegerInterface;

class Roller1d6Test extends AbstractRollerTest
{

    /**
     * @test
     */
    public function I_can_create_it()
    {
        $roller1d6 = Roller1d6::getIt();
        $this->assertSame($roller1d6, Roller1d6::getIt());
        $this->assertInstanceOf(Dice1d6::class, $roller1d6->getDice());
        $this->assertInstanceOf(IntegerInterface::class, $roller1d6->getNumberOfStandardRolls());
        $this->assertSame(1, $roller1d6->getNumberOfStandardRolls()->getValue());
        $this->assertInstanceOf(OneToOne::class, $roller1d6->getDiceRollEvaluator());
        $this->assertInstanceOf(NoRollOn::class, $roller1d6->getBonusRollOn());
        $this->assertInstanceOf(NoRollOn::class, $roller1d6->getMalusRollOn());
    }

    /**
     * @test
     */
    public function I_can_roll_by_it()
    {
        $roller1d6 = Roller1d6::getIt();
        $previousRoll = null;
        for ($round = 1; $round < self::ROLLS_ROUNDS; $round++) {
            $roll = $roller1d6->roll();
            $this->assertNotSame($previousRoll, $roll);
            $this->assertGreaterThanOrEqual($roller1d6->getDice()->getMinimum()->getValue(), $roll->getValue());
            $this->assertLessThanOrEqual($roller1d6->getDice()->getMaximum()->getValue(), $roll->getValue());
            $previousRoll = $roll;
        }
        $this->assertEquals(new Roller1d6(), $roller1d6, 'Roller has to be stateless');
    }
}
