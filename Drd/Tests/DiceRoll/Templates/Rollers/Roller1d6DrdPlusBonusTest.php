<?php
namespace Drd\DiceRoll\Templates\Rollers;

use Drd\DiceRoll\Templates\Dices\Dice1d6;
use Drd\DiceRoll\Templates\Evaluators\FourOrMoreAsOneZeroOtherwise;
use Drd\DiceRoll\Templates\RollOn\NoRollOn;
use Drd\DiceRoll\Templates\RollOn\RollOn4Plus;
use Drd\Tests\DiceRoll\Templates\Rollers\AbstractRollerTest;
use Granam\Integer\IntegerInterface;

class Roller1d6DrdPlusBonusTest extends AbstractRollerTest
{

    /**
     * @test
     */
    public function I_can_create_it()
    {
        $roller1d6DrdPlusMalus = Roller1d6DrdPlusBonus::getIt();
        self::assertSame($roller1d6DrdPlusMalus, Roller1d6DrdPlusBonus::getIt());
        self::assertInstanceOf(Dice1d6::class, $roller1d6DrdPlusMalus->getDice());
        self::assertInstanceOf(IntegerInterface::class, $roller1d6DrdPlusMalus->getNumberOfStandardRolls());
        self::assertSame(1, $roller1d6DrdPlusMalus->getNumberOfStandardRolls()->getValue());
        self::assertInstanceOf(FourOrMoreAsOneZeroOtherwise::class, $roller1d6DrdPlusMalus->getDiceRollEvaluator());
        self::assertInstanceOf(RollOn4Plus::class, $roller1d6DrdPlusMalus->getBonusRollOn());
        self::assertInstanceOf(NoRollOn::class, $roller1d6DrdPlusMalus->getMalusRollOn());
    }

    /**
     * @test
     */
    public function I_can_roll_by_it()
    {
        $roller1d6DrdPlusBonus = Roller1d6DrdPlusBonus::getIt();
        $previousRoll = null;
        for ($attempt = 1; $attempt < self::MAX_ROLL_ATTEMPTS; $attempt++) {
            $roll = $roller1d6DrdPlusBonus->roll();
            self::assertNotSame($previousRoll, $roll);
            self::assertGreaterThanOrEqual(0, $roll->getValue());
            self::assertEquals(1, count($roll->getStandardDiceRolls()));
            self::assertEquals(0, count($roll->getMalusDiceRolls()));
            if (count($roll->getBonusDiceRolls()) > 2) { // at least 2 positive bonus rolls (+ last negative bonus roll)
                self::assertEquals(
                    count($roll->getDiceRolls()) - 1, // last bonus roll does not trigger bonus value (< 4)
                    $roll->getValue()
                );
                break; // at least two bonus rolls in a row happened
            }
            $previousRoll = $roll;
        }
        self::assertLessThan(self::MAX_ROLL_ATTEMPTS, $attempt, 'Expected at least two bonuses in a row');
        self::assertEquals(new Roller1d6DrdPlusBonus(), $roller1d6DrdPlusBonus, 'Roller has to be stateless');
    }
}
