<?php
session_start();
include_once '../models/Database.php';
include_once '../models/User.php';

$errors = [];
$inputValues = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : '';
    $password = isset($_POST["pwd"]) ? trim($_POST["pwd"]) : '';
    $confirmPassword = isset($_POST["newPwd"]) ? trim($_POST["newPwd"]) : '';
    $firstName = isset($_POST["firstName"]) ? trim($_POST["firstName"]) : '';
    $lastName = isset($_POST["lastName"]) ? trim($_POST["lastName"]) : '';
    $phone = isset($_POST["phone"]) ? trim($_POST["phone"]) : '';
    $street = isset($_POST["street"]) ? trim($_POST["street"]) : '';
    $houseNumber = isset($_POST["houseNumber"]) ? trim($_POST["houseNumber"]) : '';
    $termsAccepted = isset($_POST["terms"]) ? $_POST["terms"] : '';
    $isAdmin = (strtolower($firstName) === 'admin' && strtolower($lastName) === 'admin') ? 1 : 0;

    $inputValues = [
        'email' => $email,
        'firstName' => $firstName,
        'lastName' => $lastName,
        'phone' => $phone,
        'street' => $street,
        'houseNumber' => $houseNumber,
        'terms' => $termsAccepted
    ];

    if (empty($termsAccepted)) {
        $errors[] = 'A felhasználói feltételek elfogadása kötelező';
    }
    if (empty($email)) {
        $errors[] = 'Email megadása kötelező';
    } elseif (User::findByEmail($email)) {
        $errors[] = 'Az email cím már létezik';
    }
    if (empty($password)) {
        $errors[] = 'Jelszó megadása kötelező';
    }
    if (empty($confirmPassword)) {
        $errors[] = 'Jelszó megerősítése kötelező';
    }
    if ($password !== $confirmPassword) {
        $errors[] = 'A jelszavak nem egyeznek';
    }
    if (empty($firstName)) {
        $errors[] = 'Keresztnév megadása kötelező';
    }
    if (empty($lastName)) {
        $errors[] = 'Vezetéknév megadása kötelező';
    }
    if (empty($phone)) {
        $errors[] = 'Telefonszám megadása kötelező';
    }
    if (empty($street)) {
        $errors[] = 'Utca megadása kötelező';
    }
    if (empty($houseNumber)) {
        $errors[] = 'Házszám megadása kötelező';
    }

    if (empty($errors)) {
        $user = new User( $id ,$email, $password, $firstName, $lastName, $phone, $street, $houseNumber, $isAdmin);

        if ($user->save()) {
            $_SESSION['success'] = 'Regisztráció sikeres';
            header("Location: ../view/index.php");
            exit();
        } else {
            $errors[] = 'Hiba történt a regisztráció során';
        }
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['inputValues'] = $inputValues;
    }

    header("Location: ../view/register.php");
    exit();
} else {
    echo 'Nem fasza amit csinálsz!';
}
?>
