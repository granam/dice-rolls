<?php
namespace Drd\DiceRolls\Templates\Numbers;

class Six extends Number
{
    /**
     * @return Number|Six
     */
    public static function getIt()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return self::getInstance(6);
    }
}