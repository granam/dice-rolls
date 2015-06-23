<?php
namespace Drd\DiceRoll;

use Granam\Integer\IntegerObject;
use Granam\Strict\Object\StrictObject;

class DiceRollBuilder extends StrictObject implements DiceRollBuilderInterface
{
    /**
     * @var DiceRollEvaluatorInterface
     */
    private $diceRollEvaluator;

    public function __construct(DiceRollEvaluatorInterface $diceRollEvaluator)
    {
        $this->diceRollEvaluator = $diceRollEvaluator;
    }

    /**
     * @return DiceRollEvaluatorInterface
     */
    public function getDiceRollEvaluator()
    {
        return $this->diceRollEvaluator;
    }

    /**
     * @param DiceInterface $dice
     * @param IntegerObject $rolledNumber
     * @param IntegerObject $rollSequence
     *
     * @return DiceRoll
     */
    public function create(DiceInterface $dice, IntegerObject $rolledNumber, IntegerObject $rollSequence)
    {
        return new DiceRoll($dice, $rolledNumber, $this->diceRollEvaluator, $rollSequence);
    }

}
