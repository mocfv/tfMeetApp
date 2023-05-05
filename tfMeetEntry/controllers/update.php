<?php

//Import the following classes
use Core\App;
use Core\Database;

//Initialize a Database object
$db = App::resolve(Database::class);

//Collect all the entry IDs based on the selected sex, event, and meet
$entries = $db->results(
    "SELECT ID
    FROM tblEntries
    WHERE sex = :sex
    AND combinedCode = :eventID
    AND meetID = :meetID"
    ,['sex' => $_SESSION['sex']
    ,'eventID' => $_SESSION['eventID']
    ,'meetID' => $_SESSION['meetID']]
);

//Collect the measure type of the entry mark
//Not used for now as of (5/5/23)
$measureType = $db->results(
    "SELECT type
    FROM tblEvents
    WHERE ID = :eventID"
    ,['eventID' => $_SESSION['eventID']]
);

//For each entry collected
foreach($entries as $entry){
    //Collect the mark, place, and points value from the POST variables
    //The identifier was decided to be the type of data it is {mark, place, or points} with its entry ID
        //This leads to the variables to be named {mark2, place5, points19} all of which belong to different entries
    $markValue = $_POST["mark{$entry['ID']}"];
    $placeValue = $_POST["place{$entry['ID']}"];
    $pointsValue = $_POST["points{$entry['ID']}"];
    //Run a query to update the entry data using the values collected above
    $db->query(
        "UPDATE tblEntries
        SET entryMark = :mark
        , place = :place
        ,points = :points
        WHERE ID = :ID"
        ,['mark' => $markValue
        ,'place' => $placeValue
        ,'points' => $pointsValue
        ,'ID' => $entry['ID']]
    );
}

//Set the update session variable to true to indicate that the user is coming from the update page
//This prevents some of the previous information from being reset which allows the user to continue from where they left off
$_SESSION['update'] = true;
//Set the location to the entry page
header("location: /entry");
//If the program manages to reach this point, there has been an error and stop the program
die();