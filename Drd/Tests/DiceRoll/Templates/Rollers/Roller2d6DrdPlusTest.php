<?php
namespace Drd\Tests\DiceRoll\Templates\Rollers;

use Drd\DiceRoll\Templates\Dices\Dice1d6;
use Drd\DiceRoll\Templates\Evaluators\OneToOneEvaluator;
use Drd\DiceRoll\Templates\Rollers\Roller2d6DrdPlus;
use Drd\DiceRoll\Templates\Rolls\Roll2d6DrdPlus;
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
        self::assertSame($roller2d6DrdPlus, Roller2d6DrdPlus::getIt());
        self::assertInstanceOf(Dice1d6::class, $roller2d6DrdPlus->getDice());
        self::assertInstanceOf(IntegerInterface::class, $roller2d6DrdPlus->getNumberOfStandardRolls());
        self::assertSame(2, $roller2d6DrdPlus->getNumberOfStandardRolls()->getValue());
        self::assertInstanceOf(OneToOneEvaluator::class, $roller2d6DrdPlus->getDiceRollEvaluator());
        self::assertInstanceOf(RollOn12::class, $roller2d6DrdPlus->getBonusRollOn());
        self::assertInstanceOf(RollOn2::class, $roller2d6DrdPlus->getMalusRollOn());
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
            self::assertNotSame($previousRoll, $roll);
            self::assertInstanceOf(Roll2d6DrdPlus::class, $roll);
            if (count($roll->getBonusDiceRolls()) > 2) { // at least 2 positive bonus rolls (+ last negative bonus roll)
                $atLeastTwoBonusesHappened = true;
                self::assertGreaterThan($this->summarizeDiceRolls($roll->getStandardDiceRolls()), $roll->getValue());
                self::assertCount(0, $roll->getMalusDiceRolls());
            } else if (count($roll->getMalusDiceRolls()) > 2) { // at least 2 positive malus rolls (+ last negative malus roll)
                $atLeastTwoMalusesHappened = true;
                self::assertLessThan($this->summarizeDiceRolls($roll->getStandardDiceRolls()), $roll->getValue());
                self::assertCount(0, $roll->getBonusDiceRolls());
            }
            if ($atLeastTwoBonusesHappened && $atLeastTwoMalusesHappened) {
                break;
            }
            $previousRoll = $roll;
        }

        self::assertLessThan(self::MAX_ROLL_ATTEMPTS, $attempt, 'Expected at least two bonuses in a row and two maluses in a row');
        self::assertEquals(new Roller2d6DrdPlus(), $roller2d6DrdPlus, 'Roller has to be stateless');
    }
}
