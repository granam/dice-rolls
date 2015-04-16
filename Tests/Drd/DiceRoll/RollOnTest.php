<?php
namespace Drd\DiceRoll;

class RollOnTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function summarizes_standard_bonus_and_malus_roll()
    {
        /** @var RollOn|\Mockery\MockInterface $rollOn */
        $rollOn = \Mockery::mock(RollOn::class);
        $rollOn->shouldDeferMissing(); // any non-mocked method will be used in original
        $rollOn->shouldReceive('getRoll')
            ->andReturn($roll = \Mockery::mock(Roll::class));
        $roll->shouldReceive('getLastStandardDiceRolls')
            ->andReturn($dices = [
                $firstDiceRoll = \Mockery::mock(DiceRoll::class),
                $secondDiceRoll = \Mockery::mock(DiceRoll::class),
            ]);
        $rollOn->shouldAllowMockingProtectedMethods();
        $rollOn->shouldReceive('evaluateDiceRoll')
            ->andReturn($rolledValue = 11111);
        $roll->shouldReceive('getBonusRollOn')
            ->andReturn($bonusRollOn = \Mockery::mock(RollOn::class));
        $bonusRollOn->shouldReceive('getLastRollSummary')
            ->andReturn($bonusRolledValue = 123);
        $roll->shouldReceive('getMalusRollOn')
            ->andReturn($malusRollOn = \Mockery::mock(RollOn::class));
        $malusRollOn->shouldReceive('getLastRollSummary')
            ->andReturn($malusRolledValue = 567);
        $this->assertSame((count($dices) * $rolledValue) + $bonusRolledValue + $malusRolledValue, $rollOn->getLastRollSummary());
    }
}
