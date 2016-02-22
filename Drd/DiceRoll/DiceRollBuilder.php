<?php
namespace Drd\DiceRoll;

use Granam\Integer\IntegerInterface;
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
     * @param IntegerInterface $rolledNumber
     * @param IntegerInterface $rollSequence
     *
     * @return DiceRoll
     */
    public function create(DiceInterface $dice, IntegerInterface $rolledNumber, IntegerInterface $rollSequence)
    {
        return new DiceRoll($dice, $rolledNumber, $this->diceRollEvaluator, $rollSequence);
    }

}
