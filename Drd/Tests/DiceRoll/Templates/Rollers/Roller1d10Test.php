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
        self::assertSame($roller1d10, Roller1d10::getIt());
        self::assertInstanceOf(Dice1d10::class, $roller1d10->getDice());
        self::assertInstanceOf(IntegerInterface::class, $roller1d10->getNumberOfStandardRolls());
        self::assertSame(1, $roller1d10->getNumberOfStandardRolls()->getValue());
        self::assertInstanceOf(OneToOne::class, $roller1d10->getDiceRollEvaluator());
        self::assertInstanceOf(NoRollOn::class, $roller1d10->getBonusRollOn());
        self::assertInstanceOf(NoRollOn::class, $roller1d10->getMalusRollOn());
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
            self::assertNotSame($previousRoll, $roll);
            self::assertGreaterThanOrEqual($roller1d10->getDice()->getMinimum()->getValue(), $roll->getValue());
            self::assertLessThanOrEqual($roller1d10->getDice()->getMaximum()->getValue(), $roll->getValue());
            $previousRoll = $roll;
        }
        self::assertEquals(new Roller1d10(), $roller1d10, 'Roller has to be stateless');
    }
}