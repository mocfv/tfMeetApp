<!-- Import the following files for display and navigation -->
<?php require('partials/head.php') ?>
<?php require('partials/nav.php') ?>
<?php require('partials/banner.php') ?>

<?php
    //Import the following classes
    use Core\App;
    use Core\Database;
    
    //Create a new database object
    $db = App::resolve(Database::class);
    
    //Collect all the meets available in the database
    $meets = $db->query("SELECT * FROM tblMeets")->get();

    //Set the update session variable to false
    $_SESSION['update'] = false;
?>

<main>
    <!-- Main heading that indicates the user to select a meet -->
    <div class="overflow-hidden bg-white shadow sm:rounded-lg mt-5">
    <div class="px-4 py-5 sm:px-6">
        <h3 class="text-base font-semibold leading-6 text-gray-900">Select Meet</h3>
    </div>
    <div class="border-t border-gray-200">
        <dl>
            <!-- Column headers to indicate what each column is displaying -->
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-1 sm:mt-0">Meet Name1</dd>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-1 sm:mt-0">Meet Date</dd>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-1 sm:mt-0">Meet Location</dd>
            </div>
            <!-- Start of form to select a meet -->
            <form name='meetSelect' method='POST' action='/entry'>
                <!-- For each meet -->
                <?php foreach ($meets as $meet) : ?>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
                        <!-- Add a button that displays the meet's name and sends the value of the meet's ID to the form -->
                        <button class="text-sm font-medium text-blue-500 underline" name = 'meetID' value = <?php echo $meet['ID'] ?>><?php echo $meet['meetName']?></button>
                        <!-- Display the date and location of the meet -->
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-1 sm:mt-0"><?php echo ($db->month($meet['meetDate']))." ".substr($meet['meetDate'],8,2).", ".substr($meet['meetDate'],0,4)?></dd>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-1 sm:mt-0"><?php echo $meet['location'] ?></dd>
                    </div>
                <!-- End of foreach loop -->
                <?php endforeach ?>
            <!-- End of form to select a meet -->
            </form>
        </dl>
    </div>
    </div>
</main>

<!-- Import the last file for display and navigation -->
<?php require('partials/footer.php') ?>
