<?php
namespace Drd\DiceRoll\Templates;

use Granam\Strict\Integer\StrictInteger;

class Bonus1RollOn4PlusTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     *
     * @return Bonus1RollOn4Plus
     */
    public function can_create_instance()
    {
        /** @var Dice1d6|\Mockery\MockInterface $dice1d6 */
        $dice1d6 = \Mockery::mock(Dice1d6::class);
        $dice1d6->shouldReceive('getMinimum')
            ->andReturn($minimum = \Mockery::mock(StrictInteger::class));
        $minimum->shouldReceive('getValue')
            ->andReturn(1);
        $dice1d6->shouldReceive('getMaximum')
            ->andReturn($maximum = \Mockery::mock(StrictInteger::class));
        $maximum->shouldReceive('getValue')
            ->andReturn(6);
        $instance = new Bonus1RollOn4Plus($dice1d6);
        $this->assertNotNull($instance);

        return $instance;
    }

    /**
     * @param Bonus1RollOn4Plus $bonus1RollOn4Plus
     *
     * @test
     * @depends can_create_instance
     */
    public function should_repeat_roll_on_four_plus(Bonus1RollOn4Plus $bonus1RollOn4Plus)
    {
        for ($rollValue = 1; $rollValue <= 6; $rollValue++) {
            if ($rollValue >= 4) {
                $this->assertTrue($bonus1RollOn4Plus->shouldRepeatRoll($rollValue));
            } else {
                $this->assertFalse($bonus1RollOn4Plus->shouldRepeatRoll($rollValue), "Value of $rollValue should not trigger repeat roll");
            }
        }
    }
}
