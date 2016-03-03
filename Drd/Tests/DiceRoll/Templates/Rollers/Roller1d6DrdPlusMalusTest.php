<?php
namespace Drd\Tests\DiceRoll\Templates\Rollers;

use Drd\DiceRoll\Templates\Dices\Dice1d6;
use Drd\DiceRoll\Templates\Evaluators\ThreeOrLessAsMinusOneZeroOtherwise;
use Drd\DiceRoll\Templates\Rollers\Roller1d6DrdPlusMalus;
use Drd\DiceRoll\Templates\RollOn\NoRollOn;
use Drd\DiceRoll\Templates\RollOn\RollOn3Minus;
use Granam\Integer\IntegerInterface;

class Roller1d6DrdPlusMalusTest extends AbstractRollerTest
{

    /**
     * @test
     */
    public function I_can_create_it()
    {
        $roller1d6DrdPlusMalus = Roller1d6DrdPlusMalus::getIt();
        $this->assertSame($roller1d6DrdPlusMalus, Roller1d6DrdPlusMalus::getIt());
        $this->assertInstanceOf(Dice1d6::class, $roller1d6DrdPlusMalus->getDice());
        $this->assertInstanceOf(IntegerInterface::class, $roller1d6DrdPlusMalus->getNumberOfStandardRolls());
        $this->assertSame(1, $roller1d6DrdPlusMalus->getNumberOfStandardRolls()->getValue());
        $this->assertInstanceOf(ThreeOrLessAsMinusOneZeroOtherwise::class, $roller1d6DrdPlusMalus->getDiceRollEvaluator());
        $this->assertInstanceOf(NoRollOn::class, $roller1d6DrdPlusMalus->getBonusRollOn());
        $this->assertInstanceOf(RollOn3Minus::class, $roller1d6DrdPlusMalus->getMalusRollOn());
    }

    /**
     * @test
     */
    public function I_can_roll_by_it()
    {
        $roller1d6PlusMalus = Roller1d6DrdPlusMalus::getIt();
        $previousRoll = null;
        for ($attempt = 1; $attempt < self::MAX_ROLL_ATTEMPTS; $attempt++) {
            $roll = $roller1d6PlusMalus->roll();
            $this->assertNotSame($previousRoll, $roll);
            $this->assertLessThanOrEqual(
                $roller1d6PlusMalus->getDice()->getMaximum()->getValue(),
                $roll->getValue()
            );
            $this->assertEquals(1, count($roll->getStandardDiceRolls()));
            $this->assertEquals(0, count($roll->getBonusDiceRolls()));
            $this->assertLessThanOrEqual(3, $roll->getValue());
            if (count($roll->getMalusDiceRolls()) > 2) { // at least 2 positive malus rolls (+ last negative malus)
                $this->assertSame(-1 * (count($roll->getDiceRolls()) - 1), $roll->getValue());
                break; // at least two malus rolls in a row happened
            }
            $previousRoll = $roll;
        }
        $this->assertLessThan(self::MAX_ROLL_ATTEMPTS, $attempt, 'Expected at least two maluses in a row');
        $this->assertEquals(new Roller1d6DrdPlusMalus(), $roller1d6PlusMalus, 'Roller has to be stateless');
    }
}
