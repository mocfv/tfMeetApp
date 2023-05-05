<?php

//Create the following routes when a form method is submitted to the app
$router->get('/','controllers/index.php');
$router->get('/entry','controllers/entry.php');
$router->post('/entry','controllers/entry.php');
$router->patch('/update','controllers/update.php');