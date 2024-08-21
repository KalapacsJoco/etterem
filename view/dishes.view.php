<?php
include_once __DIR__ . '/../controllers/dishes.controller.php';  // a __DIR__ a jelenlegi mappa (controllers) útvonalát adja
session_start();
$imageDir = __DIR__ . '/img/foods/';
$images = glob($imageDir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);




$title = 'Menü';
ob_start();
?>

<div class="container mx-auto p-6 overflow-auto flex-grow">
    <h1 class="text-2xl font-bold mb-4 text-center">Ételek</h1>

    <?php if (isset($_SESSION['success'])) : ?>
        <div class="  text-gray-100 px-4 py-3 rounded relative mb-4 fixed top-0 w-full">
            <?php echo $_SESSION['success'];
            unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])) : ?>
        <div class="bg-red-100  text-red-700 px-4 py-3 rounded relative mb-4">
            <?php echo $_SESSION['error'];
            unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>



    <?php
         include 'templates/dishCard.php';
    $content = ob_get_clean();
    include 'templates/layout.php';
    ?>