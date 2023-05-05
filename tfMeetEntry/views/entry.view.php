<!-- Import the partials for display and navigation -->
<?php require('partials/head.php') ?>
<?php require('partials/nav.php') ?>
<?php require('partials/banner.php') ?>

<?php

//Import the App and Database classes
use Core\App;
use Core\Database;

//Create a database object named db
$db = App::resolve(Database::class);

//If the user did not come from the update page, reset the following session variables
if($_SESSION['update'] == false){
    $_SESSION['sex'] = '';
    $_SESSION['eventID'] = '';
}

//Reset the following variables
$athletes = '';
$teams = '';

//Set the update session variable to false, mainly for the if statement above
$_SESSION['update'] = false;

//If the following POST variables are not empty, then set the corresponding session variables to those values
if(!empty($_POST['sex'])){
    $_SESSION['sex'] = $_POST['sex'];
}
if(!empty($_POST['eventID'])){
    $_SESSION['eventID'] = $_POST['eventID'];
}

//Collect the selected meet's name, location, and date from the database
$meetInfo = $db->results(
    "SELECT meetName, location, meetDate
    FROM tblMeets
    WHERE ID = :meetID"
    ,['meetID' => $_SESSION['meetID']]
);

//Collect all the sexes from the selected meet
$sexes = $db->results(
    "SELECT DISTINCT sex
    FROM tblEntries
    WHERE meetID = :meetID"
    ,['meetID' => $_SESSION['meetID']]
);

//Collect all the events from the selected meet if there exists an entry with the selected sex
$events = $db->results(
    "SELECT DISTINCT tblEvents.ID,eventName
    FROM tblEntries
    INNER JOIN tblEvents
    ON combinedCode = tblEvents.ID
    WHERE meetID = :meetID
    AND sex = :sex"
    ,['meetID' => $_SESSION['meetID']
    ,'sex' => $_SESSION['sex']]
);

//If the event starts with a D and the sex session variable is filled
if(substr($_SESSION['eventID'],0,1) == "D" && !($_SESSION['sex'] == '')){
    //Then collect all the entries for the athletes at the meet and that share the same sex and event that were selected
    $athletes = $db->results(
        "SELECT ID,nameLast,nameFirst,teamCode,entryMark,place,points
        FROM tblEntries
        WHERE sex = :sex
        AND combinedCode = :eventID
        AND meetID = :meetID"
        ,['sex' => $_SESSION['sex']
        ,'eventID' => $_SESSION['eventID']
        ,'meetID' => $_SESSION['meetID']]
    );
//Otherwise, if the event starts with a Q and the sex session variable is filled
}elseif(substr($_SESSION['eventID'],0,1) == "Q" && !($_SESSION['sex'] == '')){
    //Then collect all the entries for the theams at the meet and that share the same sex and event that were selected
    $teams = $db->results(
        "SELECT ID,teamName,teamCode,entryMark,place,points
        FROM tblEntries
        WHERE sex = :sex
        AND combinedCode = :eventID
        AND meetID = :meetID"
        ,['sex' => $_SESSION['sex']
        ,'eventID' => $_SESSION['eventID']
        ,'meetID' => $_SESSION['meetID']]
    );
}

?>

<main>
    <!-- Main header that displays the selected meet's name, location, and date -->
    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dd class="mt-1 text-sm text-gray-900 sm:col-span-1 sm:mt-0">Name: <?= $meetInfo[0]['meetName']; ?></dd>
        <dd class="mt-1 text-sm text-gray-900 sm:col-span-1 sm:mt-0">Location: <?= $meetInfo[0]['location']; ?></dd>
        <dd class="mt-1 text-sm text-gray-900 sm:col-span-1 sm:mt-0">Date: <?= ($db->month($meetInfo[0]['meetDate']))." ".substr($meetInfo[0]['meetDate'],8,2).", ".substr($meetInfo[0]['meetDate'],0,4) ?></dd>
    </div>

    <!-- Sex START -->
    <!-- Header to indicate the start of the sex section -->
    <div class="overflow-hidden bg-white shadow sm:rounded-lg mt-5">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-base font-semibold leading-6 text-gray-900">Select Sex</h3>
        </div>

        <div class="border-t border-gray-200">
            <dl>
                <!-- Start of the form to select sex -->
                <form name='selectSex' method='POST' action='/entry'>
                    <!-- Sumbit an input, so eventID is kept after submission while selecting a sex -->
                    <input type='hidden' name='eventID' value=<?= $_SESSION['eventID'] ?>>
                    <!-- For each distinct sex collected from the selected meet -->
                    <?php foreach ($sexes as $letter) : ?>
                        <!-- Create a button that represents the sex, and change the text to blue if the session sex matches the button's sex -->
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
                            <button class=<?= $_SESSION['sex'] == $letter['sex'] ? "text-blue-500" : "text-black-500" ?> name = "sex" value = <?= $letter['sex'] ?>><?= $letter['sex'] ?></button>
                        </div>
                    <!-- End of foreach loop -->
                    <?php endforeach; ?>
                <!-- End of form to select sex -->
                </form>
            </dl>
        </div>
    </div>
    <!-- Sex END -->

    <!-- Event START -->
    <!-- Header to indicate the start of the event section -->
    <div class="overflow-hidden bg-white shadow sm:rounded-lg mt-5">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-base font-semibold leading-6 text-gray-900">Select Event</h3>
        </div>

        <div class="border-t border-gray-200">
            <dl>
                <!-- Start of form to select event -->
                <form name='selectEvent' method='POST' action='/entry'>
                    <!-- Submit an input, so sex is kept after submission while selecting an event -->
                    <input type='hidden' name='sex' value=<?= $_SESSION['sex'] ?>>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-1 sm:gap-4 sm:px-6">
                        <!-- Start of select dropdown menu for events which sumbits the form when an option is chosen -->
                        <Select name = "eventID" onchange="submit()">
                            <!-- First choice is null and will display if eventID is empty -->
                            <option <?= $_SESSION['eventID'] == '' ? "Selected" : "" ?> value=''>Events</option>
                            <!-- For each distinct event collected from the selected meet and sex -->
                            <?php foreach ($events as $event) : ?>
                                <!-- Create an option that represents each event, and make it display if the session eventID matches the event's ID -->
                                <option <?= $_SESSION['eventID'] == $event['ID'] ? "Selected" : "" ?> value = <?= $event['ID'] ?>><?= $event['eventName'] ?></option>
                            <?php endforeach; ?>
                            <!-- End of foreach loop -->
                        </Select>
                        <!-- End of select dropdown menu -->
                    </div>
                </form>
                <!-- End of form to select event -->
            </dl>
        </div>
    </div>
    <!-- Event END -->

    <!-- Entry START -->
    <!-- Header to indicate the start of the entry section -->
    <div class="overflow-hidden bg-white shadow sm:rounded-lg mt-5">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-base font-semibold leading-6 text-gray-900">Enter Results</h3>
        </div>

        <div class="border-t border-gray-200">
            <dl>
                <!-- Start of form to enter entry data -->
                <form name='selectEvent' method='POST' action='/update'>
                    <!-- Submit an input that identifies the method to be a patch request which fits with the router -->
                    <input type='hidden' name='_method' value='PATCH'>
                    <!-- Submit inputs of the sex and eventID to ensure they aren't lost when returning back to the entry page -->
                    <input type='hidden' name='sex' value=<?= $_SESSION['sex'] ?>>
                    <input type='hidden' name='eventID' value=<?= $_SESSION['eventID'] ?>>
                    <!-- If athletes had been collected -->
                    <?php if(!($athletes == '')) : ?>
                        <!-- Display headers of what each column represents/displays -->
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-6 sm:gap-3 sm:px-6">
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-1 sm:mt-0 text-purple-500">Last</dd>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-1 sm:mt-0 text-purple-500">First</dd>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-1 sm:mt-0 text-purple-500">Team</dd>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-1 sm:mt-0 text-purple-500">Mark</dd>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-1 sm:mt-0 text-purple-500">Place</dd>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-1 sm:mt-0 text-purple-500">Points</dd>
                        </div>
                        <!-- For each athlete collected from the selected meet -->
                        <?php foreach ($athletes as $athlete) : ?>
                            <!-- Submit the athlete's ID to find their entry in the database -->
                            <input type='hidden' name='entryID' value=<?= $athlete['ID'] ?>>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-6 sm:gap-3 sm:px-6">
                                <!-- Display the athlete's information -->
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-1 sm:mt-0"><?= $athlete['nameLast'] ?></dd>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-1 sm:mt-0"><?= $athlete['nameFirst'] ?></dd>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-1 sm:mt-0"><?= $athlete['teamCode'] ?></dd>
                                <!-- Make text inputs that allow the user to change the entry mark, place, and points of the athlete -->
                                <!-- Attach the athlete's ID to the name to make it identifiable when inserting the data into the database -->
                                <input type='text' id="mark<?= $athlete['ID'] ?>" name="mark<?= $athlete['ID'] ?>" value=<?= $athlete['entryMark'] ?? '' ?>>
                                <input type='text' id="place<?= $athlete['ID'] ?>" name="place<?= $athlete['ID'] ?>" value=<?= $athlete['place'] ?? '' ?>>
                                <input type='text' id="points<?= $athlete['ID'] ?>" name="points<?= $athlete['ID'] ?>" value=<?= $athlete['points'] ?? '' ?>>
                            </div>
                        <!-- End of foreach loop -->
                        <?php endforeach; ?>
                    <!-- If teams were collected -->
                    <?php elseif(!($teams == '')) : ?>
                        <!-- Display headers of what each column displays/represents -->
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-5 sm:gap-3 sm:px-6">
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-1 sm:mt-0 text-purple-500">Team Name</dd>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-1 sm:mt-0 text-purple-500">Team Code</dd>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-1 sm:mt-0 text-purple-500">Mark</dd>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-1 sm:mt-0 text-purple-500">Place</dd>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-1 sm:mt-0 text-purple-500">Points</dd>
                        </div>
                        <!-- For each athlete collected from the selected meet -->
                        <?php foreach ($teams as $team) : ?>
                            <!-- Submit the team's ID to find their entry in the database -->
                            <input type='hidden' name='entryID' value=<?= $team['ID'] ?>>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-5 sm:gap-3 sm:px-6">
                                <!-- Display the team's information -->
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-1 sm:mt-0"><?= $team['teamName'] ?></dd>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-1 sm:mt-0"><?= $team['teamCode'] ?></dd>
                                <!-- Make text inputs that allow the user to change the entry mark, place, and points of the team -->
                                <!-- Attach the team's ID to the name to make it identifiable when inserting the data into the database -->
                                <input type='text' id="mark<?= $team['ID'] ?>" name="mark<?= $team['ID'] ?>" value=<?= $team['entryMark'] ?? '' ?>>
                                <input type='text' id="place<?= $team['ID'] ?>" name="place<?= $team['ID'] ?>" value=<?= $team['place'] ?? '' ?>>
                                <input type='text' id="points<?= $team['ID'] ?>" name="points<?= $team['ID'] ?>" value=<?= $team['points'] ?? '' ?>>
                            </div>
                        <!-- End foreach loop -->
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <!-- Make a submit input, so the form submits when the user presses the enter key -->
                    <input type='submit' style="display:none;">
                <!-- End of form to enter entry data -->
                </form>
            </dl>
        </div>
    </div>
    <!-- Entry END -->
</main>

<!-- Import the final part of the partials that help with display and navigation -->
<?php require('partials/footer.php') ?>