<?php
declare(strict_types=1);

namespace DrdPlus\DiceRolls\Templates\Numbers;

class Four extends Number
{
    /**
     * @return Number|Four
     */
    public static function getIt(): Four
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return self::getInstance(4);
    }
}