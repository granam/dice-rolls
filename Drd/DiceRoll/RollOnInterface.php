<?php
namespace Drd\DiceRoll;

interface RollOnInterface
{
    /**
     * @param int $rolledValue
     *
     * @return bool
     */
    public function shouldRepeatRoll($rolledValue);

    /**
     * @return Roll
     */
    public function getRoll();

    /**
     * @return int
     */
    public function getLastRollSummary();

}
