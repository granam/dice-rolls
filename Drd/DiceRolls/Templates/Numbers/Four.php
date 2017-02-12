<?php
namespace Drd\DiceRolls\Templates\Numbers;

class Four extends Number
{
    /**
     * @return Number|Four
     */
    public static function getIt()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return self::getInstance(4);
    }
}