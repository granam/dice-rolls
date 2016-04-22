<?php
namespace Drd\Tests\DiceRoll\Templates\Rollers;

use Drd\DiceRoll\Templates\Dices\Dice1d4;
use Drd\DiceRoll\Templates\Evaluators\OneToOne;
use Drd\DiceRoll\Templates\Rollers\Roller1d4;
use Drd\DiceRoll\Templates\RollOn\NoRollOn;
use Granam\Integer\IntegerInterface;

class Roller1d4Test extends AbstractRollerTest
{

    /**
     * @test
     */
    public function I_can_create_it()
    {
        $roller1d4 = Roller1d4::getIt();
        self::assertSame($roller1d4, Roller1d4::getIt());
        self::assertInstanceOf(Dice1d4::class, $roller1d4->getDice());
        self::assertInstanceOf(IntegerInterface::class, $roller1d4->getNumberOfStandardRolls());
        self::assertSame(1, $roller1d4->getNumberOfStandardRolls()->getValue());
        self::assertInstanceOf(OneToOne::class, $roller1d4->getDiceRollEvaluator());
        self::assertInstanceOf(NoRollOn::class, $roller1d4->getBonusRollOn());
        self::assertInstanceOf(NoRollOn::class, $roller1d4->getMalusRollOn());
    }

    /**
     * @test
     */
    public function I_can_roll_by_it()
    {
        $roller1d4 = Roller1d4::getIt();
        $previousRoll = null;
        for ($attempt = 1; $attempt < 10; $attempt++) {
            $roll = $roller1d4->roll();
            self::assertNotSame($previousRoll, $roll);
            self::assertGreaterThanOrEqual($roller1d4->getDice()->getMinimum()->getValue(), $roll->getValue());
            self::assertLessThanOrEqual($roller1d4->getDice()->getMaximum()->getValue(), $roll->getValue());
            $previousRoll = $roll;
        }
        self::assertEquals(new Roller1d4(), $roller1d4, 'Roller has to be stateless');
    }
}