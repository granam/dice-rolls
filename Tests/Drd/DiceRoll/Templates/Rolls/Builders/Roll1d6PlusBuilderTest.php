<?php
namespace Drd\DiceRoll\Templates\Rolls\Builders;

use Drd\DiceRoll\Templates\Rolls\Roll1d6Plus;

class Roll1d6PlusBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return Roll1d6PlusBuilder
     *
     * @test
     */
    public function can_create_instance()
    {
        $instance = new Roll1d6PlusBuilder();
        $this->assertNotNull($instance);

        return $instance;
    }

    /**
     * @param Roll1d6PlusBuilder $builder
     *
     * @test
     * @depends can_create_instance
     */
    public function creates_1d6_plus_roll(Roll1d6PlusBuilder $builder)
    {
        $this->assertInstanceOf(Roll1d6Plus::class, $builder->createRoll());
    }
}
