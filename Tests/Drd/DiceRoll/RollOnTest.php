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
        $evaluatedDices = [];
        $rolledValue = 12345;
        $rollOn->shouldReceive('evaluateDiceRoll')
            ->andReturnUsing(function() use (&$evaluatedDices, $rolledValue) {
                $evaluatedDices[] = func_get_args()[0];
                return $rolledValue;
            });
        $roll->shouldReceive('getBonusRollOn')
            ->andReturn($bonusRollOn = \Mockery::mock(RollOn::class));
        $bonusRollOn->shouldReceive('getLastRollSummary')
            ->andReturn($bonusRolledValue = 123);
        $bonusRollOn->shouldReceive('happened')
            ->andReturn(true);
        $roll->shouldReceive('getMalusRollOn')
            ->andReturn($malusRollOn = \Mockery::mock(RollOn::class));
        $malusRollOn->shouldReceive('getLastRollSummary')
            ->andReturn($malusRolledValue = 567);
        $malusRollOn->shouldReceive('happened')
            ->andReturn(true);
        $this->assertSame((count($dices) * $rolledValue) + $bonusRolledValue + $malusRolledValue, $rollOn->getLastRollSummary());
        $this->assertSame(count($dices), count($evaluatedDices), 'Count of input dices does not match count of evaluated dices');
        $this->assertSame($dices[0], $evaluatedDices[0]);
        $this->assertSame($dices[1], $evaluatedDices[1]);
    }
}
