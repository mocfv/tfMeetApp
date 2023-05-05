<!-- Import the following files for display and navigation -->
<?php require('partials/head.php') ?>
<?php require('partials/nav.php') ?>

<!-- Runs if the user accessed something they are not authorized to -->
<main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold">You are not authorized to view this page.</h1>

        <p class="mt-4">
            <!-- Allow the user to return to the home page -->
            <a href="/" class="text-blue-500 underline">Go back home.</a>
        </p>
    </div>
</main>

<!-- Import the last file for display and navigation -->
<?php require('partials/footer.php') ?>
