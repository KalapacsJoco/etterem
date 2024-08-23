<?php
include_once __DIR__ . '/../models/Dish.php';  // a __DIR__ a jelenlegi mappa (controllers) útvonalát adja


// Fetch all dishes from the model
$dishes = Dish::findAll();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
}



?>
