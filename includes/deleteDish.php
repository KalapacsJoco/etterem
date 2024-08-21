<?php
include_once '../models/Dish.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteDish'])) {
    
    // Ellenőrizzük, hogy a 'delete_dish_id' át lett-e adva
    if (isset($_POST['delete_dish_id'])) {
        $deleteDishId = $_POST['delete_dish_id'];

        // Keresd meg és távolítsd el az adott ID-jú elemet a kosárból
        foreach ($_SESSION['cart'] as $key => $dish) {
            if ($dish->id == $deleteDishId) {
                unset($_SESSION['cart'][$key]);
                break;
            }
        }

        // Rendezze újra a kosár elemeit, hogy a kulcsok folyamatosak maradjanak
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    } else {
        $_SESSION['error'] = 'Az eltávolítandó étel azonosítója nem található.';
    }
}

// Visszairányítjuk a felhasználót az order.view.php oldalra
header("Location: ../view/order.view.php");
exit();
