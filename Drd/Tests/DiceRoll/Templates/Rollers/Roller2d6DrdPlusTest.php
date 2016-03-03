<?php
namespace Drd\Tests\DiceRoll\Templates\Rollers;

use Drd\DiceRoll\Templates\Dices\Dice1d6;
use Drd\DiceRoll\Templates\Evaluators\OneToOne;
use Drd\DiceRoll\Templates\Rollers\Roller2d6DrdPlus;
use Drd\DiceRoll\Templates\RollOn\RollOn12;
use Drd\DiceRoll\Templates\RollOn\RollOn2;
use Granam\Integer\IntegerInterface;

class Roller2d6DrdPlusTest extends AbstractRollerTest
{

    /**
     * @test
     */
    public function I_can_create_it()
    {
        $roller2d6DrdPlus = Roller2d6DrdPlus::getIt();
        $this->assertSame($roller2d6DrdPlus, Roller2d6DrdPlus::getIt());
        $this->assertInstanceOf(Dice1d6::class, $roller2d6DrdPlus->getDice());
        $this->assertInstanceOf(IntegerInterface::class, $roller2d6DrdPlus->getNumberOfStandardRolls());
        $this->assertSame(2, $roller2d6DrdPlus->getNumberOfStandardRolls()->getValue());
        $this->assertInstanceOf(OneToOne::class, $roller2d6DrdPlus->getDiceRollEvaluator());
        $this->assertInstanceOf(RollOn12::class, $roller2d6DrdPlus->getBonusRollOn());
        $this->assertInstanceOf(RollOn2::class, $roller2d6DrdPlus->getMalusRollOn());
    }

    /**
     * @test
     */
    public function I_can_roll_by_it()
    {
        $roller2d6DrdPlus = Roller2d6DrdPlus::getIt();
        $previousRoll = null;
        $atLeastTwoBonusesHappened = false;
        $atLeastTwoMalusesHappened = false;
        for ($attempt = 1; $attempt < self::MAX_ROLL_ATTEMPTS; $attempt++) {
            $roll = $roller2d6DrdPlus->roll();
            $this->assertNotSame($previousRoll, $roll);
            if (count($roll->getBonusDiceRolls()) > 2) { // at least 2 positive bonus rolls (+ last negative bonus roll)
                $atLeastTwoBonusesHappened = true;
                $this->assertGreaterThan($this->summarizeDiceRolls($roll->getStandardDiceRolls()), $roll->getValue());
                $this->assertCount(0, $roll->getMalusDiceRolls());
            } else if (count($roll->getMalusDiceRolls()) > 2) { // at least 2 positive malus rolls (+ last negative malus roll)
                $atLeastTwoMalusesHappened = true;
                $this->assertLessThan($this->summarizeDiceRolls($roll->getStandardDiceRolls()), $roll->getValue());
                $this->assertCount(0, $roll->getBonusDiceRolls());
            }
            if ($atLeastTwoBonusesHappened && $atLeastTwoMalusesHappened) {
                break;
            }
            $previousRoll = $roll;
        }

        $this->assertLessThan(self::MAX_ROLL_ATTEMPTS, $attempt, 'Expected at least two bonuses in a row and two maluses in a row');
        $this->assertEquals(new Roller2d6DrdPlus(), $roller2d6DrdPlus, 'Roller has to be stateless');
    }
}
