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
        self::assertSame($roller1d6, Roller1d6::getIt());
        self::assertInstanceOf(Dice1d6::class, $roller1d6->getDice());
        self::assertInstanceOf(IntegerInterface::class, $roller1d6->getNumberOfStandardRolls());
        self::assertSame(1, $roller1d6->getNumberOfStandardRolls()->getValue());
        self::assertInstanceOf(OneToOne::class, $roller1d6->getDiceRollEvaluator());
        self::assertInstanceOf(NoRollOn::class, $roller1d6->getBonusRollOn());
        self::assertInstanceOf(NoRollOn::class, $roller1d6->getMalusRollOn());
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
            self::assertNotSame($previousRoll, $roll);
            self::assertGreaterThanOrEqual($roller1d6->getDice()->getMinimum()->getValue(), $roll->getValue());
            self::assertLessThanOrEqual($roller1d6->getDice()->getMaximum()->getValue(), $roll->getValue());
            $previousRoll = $roll;
        }
        self::assertEquals(new Roller1d6(), $roller1d6, 'Roller has to be stateless');
    }
}
