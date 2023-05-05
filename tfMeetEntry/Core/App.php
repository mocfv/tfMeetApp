<?php

//Set the namespace of this class
namespace Core;

class App{
    //Create a static variable that can only be accessed within the class without a method
    protected static $container;

    //Set the container to some input
    public static function setContainer($container){
        static::$container = $container;
    }

    //Return the value in the container
    public static function container(){
        return static::$container;
    }

    //Bind some key and resolver?
    //Review Jerry's work from PHP for Beginners
    public static function bind($key,$resolver){
        static::container()->bind($key,$resolver);
    }

    //Resolve whatever is in the container
    //Review Jerry's work from PHP for Beginners
    public static function resolve($key){
        return static::container()->resolve($key);
    }
}
