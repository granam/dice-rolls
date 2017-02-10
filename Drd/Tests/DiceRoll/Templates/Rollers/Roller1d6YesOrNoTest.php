<?php
namespace Drd\Tests\DiceRoll\Templates\Rollers;

use Drd\DiceRoll\Templates\Dices\Dice1d6;
use Drd\DiceRoll\Templates\Evaluators\FourOrMoreAsOneZeroOtherwiseEvaluator;
use Drd\DiceRoll\Templates\Rollers\Roller1d6YesOrNo;
use Drd\DiceRoll\Templates\RollOn\NoRollOn;
use Granam\Integer\IntegerInterface;

class Roller1d6YesOrNoTest extends AbstractRollerTest
{
    /**
     * @test
     */
    public function I_can_create_it()
    {
        $roller1d6YesOrNo = Roller1d6YesOrNo::getIt();
        self::assertSame($roller1d6YesOrNo, Roller1d6YesOrNo::getIt());
        self::assertInstanceOf(Dice1d6::class, $roller1d6YesOrNo->getDice());
        self::assertInstanceOf(IntegerInterface::class, $roller1d6YesOrNo->getNumberOfStandardRolls());
        self::assertSame(1, $roller1d6YesOrNo->getNumberOfStandardRolls()->getValue());
        self::assertInstanceOf(FourOrMoreAsOneZeroOtherwiseEvaluator::class, $roller1d6YesOrNo->getDiceRollEvaluator());
        self::assertInstanceOf(NoRollOn::class, $roller1d6YesOrNo->getBonusRollOn());
        self::assertInstanceOf(NoRollOn::class, $roller1d6YesOrNo->getMalusRollOn());
    }

    /**
     * @test
     */
    public function I_can_roll_by_it()
    {
        $roller1d6YesOrNo = Roller1d6YesOrNo::getIt();
        $waitingForValues = [0, 1];
        $attemptsRemain = 1000;
        do {
            $roll = $roller1d6YesOrNo->roll();
            foreach ($waitingForValues as $index => $waitingForValue) {
                if ($waitingForValue === $roll->getValue()) {
                    unset($waitingForValues[$index]);
                    break;
                }
            }
        } while (count($waitingForValues) > 0 && --$attemptsRemain > 0);
        self::assertEmpty($waitingForValues);
    }

}