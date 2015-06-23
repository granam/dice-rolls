<?php
namespace Drd\DiceRoll\Templates\Dices;

use Drd\DiceRoll\Dice;
use Drd\DiceRoll\DiceInterface;
use Granam\Integer\IntegerObject;
use Granam\Strict\Object\StrictObject;

class Dices extends StrictObject implements DiceInterface
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
     */
    public function __construct(array $dices)
    {
        $this->checkDices($dices);
        $this->dices = $dices;
    }

    /**
     * @param array|Dice[] $dices
     */
    private function checkDices(array $dices)
    {
        if (count($dices) === 0) {
            throw new \LogicException('No dice given.');
        }

        foreach ($dices as $dice) {
            if (!is_a($dice, DiceInterface::class)) {
                throw new \LogicException('Given dices have to DiceInterface, got ' . is_object($dice) ? get_class($dice) : gettype($dice));
            }
        }
    }

    /**
     * @return IntegerObject
     */
    public function getMinimum()
    {
        if (!isset($this->minimum)) {
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
                    function (DiceInterface $dice) {
                        return $dice->getMinimum()->getValue();
                    },
                    $this->dices
                )
            )
        );
    }

    /**
     * @return IntegerObject
     */
    public function getMaximum()
    {
        if (!isset($this->maximum)) {
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
                    function (DiceInterface $dice) {
                        return $dice->getMaximum()->getValue();
                    },
                    $this->dices
                )
            )
        );
    }
}
