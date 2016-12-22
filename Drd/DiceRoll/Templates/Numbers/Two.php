<?php
namespace Drd\DiceRoll\Templates\Numbers;

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