<?php

// Create a session to allow for variables to carry across pages easily
session_start();

//Create a static Constant to ease routing to other files
const BASE_PATH = __DIR__.'/../';

//Import the functions from the Core folder
require BASE_PATH.'Core/functions.php';

//Autoload classes that are needed when they are used
spl_autoload_register(function ($class) {
    $class = str_replace('\\',DIRECTORY_SEPARATOR,$class);
    require base_path("{$class}.php");
});

//Import the bootstrap file to allow for the use of a container
//Not sure if it is every used in this app
require base_path('bootstrap.php');

//Initialize a new Router object
$router = new \Core\Router();

//Collect the routes in the routes file
$routes = require base_path('routes.php');

//Get the uri from the url/information in the server
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
//Create a method from the POST variable or the server variable if the POST variable is null
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

//Have the router create a path to the desired file
$router->route($uri,$method);
