<?php

//Set the namespace of the class
namespace Core;

class Container
{
    //Create a protected array that stores the binding
    protected $bindings = [];
    //Insert the resolver in the bindings array that is identified using the input key
    public function bind($key,$resolver){
        $this->bindings[$key] = $resolver;
    }

    //Execute a function that is stored in the bindings array
    public function resolve($key){
        if(!array_key_exists($key,$this->bindings)){
            throw new \Exception("No matching binding found for {$key}");
        }
        $resolver = $this->bindings[$key];
        return call_user_func($resolver);
    }
}