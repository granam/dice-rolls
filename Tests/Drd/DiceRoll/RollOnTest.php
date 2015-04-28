<?php
namespace Drd\DiceRoll;

class RollOnTest extends \PHPUnit_Framework_TestCase
{

    protected function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function summarizes_standard_bonus_and_malus_roll()
    {
        /** @var RollOnInterface|\Mockery\MockInterface $rollOn */
        $rollOn = \Mockery::mock(RollOnInterface::class);
        $rollOn->shouldDeferMissing(); // any non-mocked method will be used in original
        $rollOn->shouldReceive('getRoll')
            ->andReturn($roll = \Mockery::mock(Roll::class));
        $roll->shouldReceive('getLastStandardDiceRolls')
            ->andReturn($dices = [
                $firstDiceRoll = \Mockery::mock(DiceRoll::class),
                $secondDiceRoll = \Mockery::mock(DiceRoll::class),
            ]);
        $rollOn->shouldAllowMockingProtectedMethods();
        $roll->shouldReceive('getBonusRollOn')
            ->andReturn($bonusRollOn = \Mockery::mock(RollOnInterface::class));
        $bonusRollOn->shouldReceive('getLastRollSummary')
            ->andReturn($bonusRolledValue = 123);
        $bonusRollOn->shouldReceive('happened')
            ->andReturn(true);
        $roll->shouldReceive('getMalusRollOn')
            ->andReturn($malusRollOn = \Mockery::mock(RollOnInterface::class));
        $malusRollOn->shouldReceive('getLastRollSummary')
            ->andReturn($malusRolledValue = 567);
        $malusRollOn->shouldReceive('happened')
            ->andReturn(true);
    }
}
