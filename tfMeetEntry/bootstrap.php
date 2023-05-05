<?php

//Import the following classes
use Core\App;
use Core\Container;
use Core\Database;

//Create a new container
$container = new Container();

$container->bind('Core\Database', function(){
    $config = require base_path('config.php');
    return new Database($config['database']);
});

App::setContainer($container);