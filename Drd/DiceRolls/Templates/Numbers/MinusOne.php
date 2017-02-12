<?php
namespace Drd\DiceRolls\Templates\Numbers;

class MinusOne extends Number
{
    /**
     * @return Number|MinusOne
     */
    public static function getIt()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return self::getInstance(-1);
    }
}