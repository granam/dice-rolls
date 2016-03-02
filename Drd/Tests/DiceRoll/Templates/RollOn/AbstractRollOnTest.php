<?php
namespace Drd\Tests\DiceRoll\Templates\RollOn;

use Drd\DiceRoll\Roll;
use Drd\DiceRoll\Roller;
use Drd\DiceRoll\RollOn;
use Granam\Tests\Tools\TestWithMockery;

abstract class AbstractRollOnTest extends TestWithMockery
{

    protected function setUp()
    {
        parent::setUp();
        if (!defined('PHP_INT_MIN')) {
            define('PHP_INT_MIN', (int)(PHP_INT_MAX + 1)); // overflow results into lowest negative integer
        }
    }

    /**
     * @test
     */
    public function I_get_expected_dice_rolls()
    {
        $rollOn = $this->createRollOn($this->createRoller($diceRolls = 'foo'));
        $this->assertSame($diceRolls, $rollOn->rollDices());
    }

    /**
     * @param Roller $roller
     * @return RollOn
     */
    protected function createRollOn(Roller $roller)
    {
        $sutClass = preg_replace('~[\\\]Tests([\\\].+[\\\]\w+)Test$~', '$1', static::class);

        return new $sutClass($roller);
    }

    /**
     * @param $diceRolls
     * @return \Mockery\MockInterface|Roller
     */
    protected function createRoller($diceRolls = [])
    {
        $roller = $this->mockery(Roller::class);
        $roller->shouldReceive('roll')
            ->andReturn($roll = $this->mockery(Roll::class));
        $roll->shouldReceive('getDiceRolls')
            ->andReturn($diceRolls);

        return $roller;
    }
}
