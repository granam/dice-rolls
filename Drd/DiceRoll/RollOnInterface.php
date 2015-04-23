<?php
namespace Drd\DiceRoll;

interface RollOnInterface
{
    /**
     * @param int $rolledValue
     *
     * @return bool
     */
    public function shouldHappen($rolledValue);

    /**
     * The roll, used in case of bonus / malus
     *
     * @return Roll
     */
    public function getRoll();

    /**
     * Has the bonus / malus roll already happened?
     *
     * @return bool
     */
    public function happened();

}
