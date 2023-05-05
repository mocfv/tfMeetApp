<?php

//Set the namespace of the class
namespace Core;

class Validator
{
    //Check if the given value is within the given limits
    //Return true or false
    public static function string($value, $min = 1, $max = INF)
    {
        //Remove extra spaces that are not needed, so they aren't a part of the character count
        $value = trim($value);

        return strlen($value) >= $min && strlen($value) <= $max;
    }

    //Check if the given value is at least in the correct format of an email
    //Return true or false
    public static function email($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}
