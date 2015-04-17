<?php
namespace Drd\DiceRoll\Templates;

use Granam\Strict\Integer\StrictInteger;

class Malus1RollOn3MinusTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     *
     * @return Malus1RollOn3Minus
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
        $instance = new Malus1RollOn3Minus($dice1d6);
        $this->assertNotNull($instance);

        return $instance;
    }

    /**
     * @param Malus1RollOn3Minus $malus1RollOn3Minus
     *
     * @test
     * @depends can_create_instance
     */
    public function should_repeat_roll_on_four_plus(Malus1RollOn3Minus $malus1RollOn3Minus)
    {
        for ($rollValue = 1; $rollValue <= 6; $rollValue++) {
            if ($rollValue <= 3) {
                $this->assertTrue($malus1RollOn3Minus->shouldRepeatRoll($rollValue));
            } else {
                $this->assertFalse($malus1RollOn3Minus->shouldRepeatRoll($rollValue), "Value of $rollValue should not trigger repeat roll");
            }
        }
    }
}
