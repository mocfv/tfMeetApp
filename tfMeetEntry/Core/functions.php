<?php

//Import the Response class
use Core\Response;

//vardump the given value and then kill the program
//Used for debugging purposes
function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    die();
}

//Check if the uri is the given value
function urlIs($value)
{
    return $_SERVER['REQUEST_URI'] === $value;
}

//The program has run an issue, so set the error code, import the view page of the code, and kill the program
function abort($code = 404) {
    http_response_code($code);

    require base_path("views/{$code}.php");

    die();
}

//If the given condition is not true, then abort the program using the given status
function authorize($condition, $status = Response::FORBIDDEN)
{
    if (! $condition) {
        abort($status);
    }
}

//Return a path using the BASE_PATH constant
function base_path($path)
{
    return BASE_PATH . $path;
}

//Create variables from the given attributes array and then import the desired view
function view($path, $attributes = [])
{
    extract($attributes);

    require base_path('views/' . $path);
}