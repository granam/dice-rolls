<?php
namespace Drd\DiceRoll\Templates\Dices;

use Drd\DiceRoll\Dice;
use Granam\Integer\IntegerInterface;
use Granam\Integer\IntegerObject;
use Granam\Strict\Object\StrictObject;
use Granam\Tools\ValueDescriber;

class Dices extends StrictObject implements Dice
{
    /**
     * @var array|Dice[]
     */
    private $dices;
    /**
     * @var IntegerObject
     */
    private $minimum;
    /**
     * @var IntegerObject
     */
    private $maximum;

    /**
     * @param array|Dice[] $dices
     * @throws \LogicException
     */
    public function __construct(array $dices)
    {
        $this->checkDices($dices);
        $this->dices = $dices;
    }

    /**
     * @param array|Dice[] $dices
     * @throws \LogicException
     */
    private function checkDices(array $dices)
    {
        if (count($dices) === 0) {
            throw new \LogicException('No dice given.');
        }

        foreach ($dices as $dice) {
            if (!is_a($dice, Dice::class)) {
                throw new \LogicException(
                    'Given dices have to be DiceInterface, got ' . ValueDescriber::describe($dice)
                );
            }
        }
    }

    /**
     * @return IntegerInterface
     */
    public function getMinimum()
    {
        if ($this->minimum === null) {
            $this->minimum = $this->createMinimum();
        }

        return $this->minimum;
    }

    /**
     * @return IntegerObject
     */
    private function createMinimum()
    {
        return new IntegerObject(
            array_sum(
                array_map(
                    function (Dice $dice) {
                        return $dice->getMinimum()->getValue();
                    },
                    $this->dices
                )
            )
        );
    }

    /**
     * @return IntegerInterface
     */
    public function getMaximum()
    {
        if ($this->maximum === null) {
            $this->maximum = $this->createMaximum();
        }

        return $this->maximum;
    }

    /**
     * @return IntegerObject
     */
    private function createMaximum()
    {
        return new IntegerObject(
            array_sum(
                array_map(
                    function (Dice $dice) {
                        return $dice->getMaximum()->getValue();
                    },
                    $this->dices
                )
            )
        );
    }
}
