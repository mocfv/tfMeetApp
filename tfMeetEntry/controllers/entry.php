<?php

//Set the heading
$heading = 'Entry';

//If the POST variable of meetID exists, then set the respective session variable to the same thing
if(!empty($_POST['meetID'])){
    $_SESSION['meetID'] = $_POST['meetID'];
}

//Import the view of the entry page
require(base_path('views/entry.view.php'));