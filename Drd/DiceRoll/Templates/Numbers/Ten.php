<?php
namespace Drd\DiceRoll\Templates\Numbers;

class Ten extends Number
{
    /**
     * @return Number|Ten
     */
    public static function getIt()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return self::getInstance(10);
    }
}