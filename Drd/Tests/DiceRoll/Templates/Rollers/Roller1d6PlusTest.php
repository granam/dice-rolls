<?php
namespace Drd\Tests\DiceRoll\Templates\Rollers;

use Drd\DiceRoll\Templates\Dices\Dice1d6;
use Drd\DiceRoll\Templates\Evaluators\OneToOne;
use Drd\DiceRoll\Templates\Rollers\Roller1d6Plus;
use Drd\DiceRoll\Templates\RollOn\NoRollOn;
use Drd\DiceRoll\Templates\RollOn\RollOn6;
use Granam\Integer\IntegerInterface;

class Roller1d6PlusTest extends AbstractRollerTest
{

    /**
     * @test
     */
    public function I_can_create_it()
    {
        $roller1d6Plus = Roller1d6Plus::getIt();
        $this->assertSame($roller1d6Plus, Roller1d6Plus::getIt());
        $this->assertInstanceOf(Dice1d6::class, $roller1d6Plus->getDice());
        $this->assertInstanceOf(IntegerInterface::class, $roller1d6Plus->getNumberOfStandardRolls());
        $this->assertSame(1, $roller1d6Plus->getNumberOfStandardRolls()->getValue());
        $this->assertInstanceOf(OneToOne::class, $roller1d6Plus->getDiceRollEvaluator());
        $this->assertInstanceOf(RollOn6::class, $roller1d6Plus->getBonusRollOn());
        $this->assertInstanceOf(NoRollOn::class, $roller1d6Plus->getMalusRollOn());
    }

    /**
     * @test
     */
    public function I_can_roll_by_it()
    {
        $roller1d6Plus = Roller1d6Plus::getIt();
        $previousRoll = null;
        $roll = null;
        for ($attempt = 1; $attempt < self::ROLLS_ATTEMPTS_COUNT; $attempt++) {
            $roll = $roller1d6Plus->roll();
            $this->assertNotSame($previousRoll, $roll);
            $diceMinimum = $roller1d6Plus->getDice()->getMinimum()->getValue();
            $this->assertGreaterThanOrEqual($diceMinimum, $roll->getValue());
            $this->assertCount(0, $roll->getMalusDiceRolls());
            if (count($roll->getBonusDiceRolls()) > 2) { // at least 2 positive bonus rolls happens (+ last negative)
                $this->assertGreaterThanOrEqual(
                    $this->summarizeDiceRolls($roll->getStandardDiceRolls()) + (count($roll->getBonusDiceRolls()) * $diceMinimum),
                    $roll->getValue()
                );
                break;
            }
            $previousRoll = $roll;
        }
        $this->assertLessThan(self::ROLLS_ATTEMPTS_COUNT, $attempt, 'Expected at least two bonuses in a row');
        $this->assertEquals(new Roller1d6Plus(), $roller1d6Plus, 'Roller has to be stateless');
    }
}
