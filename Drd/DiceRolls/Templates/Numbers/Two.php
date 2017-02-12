<?php
namespace Drd\DiceRolls\Templates\Numbers;

class Two extends Number
{
    /**
     * @return Number|Two
     */
    public static function getIt()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return self::getInstance(2);
    }
}