<?php

include_once __DIR__ . '/../models/Database.php'; 
include_once __DIR__ . '/../models/User.php';
session_start();

$errors = [];
$inputValues = [];

$userId = $_SESSION['user']['id'] ?? null;

if ($userId) {
    $user = User::findById($userId);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Ellenőrizzük a firstName mezőt
        if (isset($_POST['firstName']) && !empty(trim($_POST['firstName']))) {
            $firstName = trim($_POST['firstName']);
        } else {
            $errors[] = 'Keresztnév megadása kötelező';
        }

        // Ellenőrizzük a lastName mezőt
        if (isset($_POST['lastName']) && !empty(trim($_POST['lastName']))) {
            $lastName = trim($_POST['lastName']);
        } else {
            $errors[] = 'Vezetéknév megadása kötelező';
        }

        // Ellenőrizzük a phoneNumber mezőt
        if (isset($_POST['phoneNumber']) && !empty(trim($_POST['phoneNumber']))) {
            $phoneNumber = trim($_POST['phoneNumber']);
        } else {
            $errors[] = 'Telefonszám megadása kötelező';
        }

        // Ellenőrizzük a street mezőt
        if (isset($_POST['street']) && !empty(trim($_POST['street']))) {
            $street = trim($_POST['street']);
        } else {
            $errors[] = 'Utcanév megadása kötelező';
        }

        // Ellenőrizzük a houseNumber mezőt
        if (isset($_POST['houseNumber']) && !empty(trim($_POST['houseNumber']))) {
            $houseNumber = trim($_POST['houseNumber']);
        } else {
            $errors[] = 'Házszám megadása kötelező';
        }

        // Ha nincsenek hibák, frissítjük a felhasználó adatait
        if (empty($errors)) {
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setPhoneNumber($phoneNumber);
            $user->setStreet($street);
            $user->setHouseNumber($houseNumber);

            // Mentsük el a felhasználói adatokat
            $user->save();
            $_SESSION['success'] = 'A felhasználói adatok sikeresen frissítve.';
        } else {
            $_SESSION['errors'] = $errors;
        }

        header("Location: /etterem/view/order");
        exit();
    }
} else {
    echo 'Felhasználó nem található!';
}
