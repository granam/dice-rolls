<?php
namespace Drd\DiceRoll;

use Granam\Strict\Integer\StrictInteger;
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
     * @param Dice $dice
     * @param StrictInteger $rolledValue
     * @param StrictInteger $rollSequence
     *
     * @return DiceRoll
     */
    public function create(Dice $dice, StrictInteger $rolledValue, StrictInteger $rollSequence)
    {
        return new DiceRoll($dice, $rolledValue, $this->diceRollEvaluator, $rollSequence);
    }

}
