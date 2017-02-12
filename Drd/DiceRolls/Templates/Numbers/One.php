<?php
namespace Drd\DiceRolls\Templates\Numbers;

class One extends Number
{
    /**
     * @return Number|One
     */
    public static function getIt()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return self::getInstance(1);
    }
}