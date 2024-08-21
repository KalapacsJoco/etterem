<?php
session_start();
include_once '../models/Database.php';
include_once '../models/User.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : '';
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : '';

    $user = User::findByEmail($email);

    if ($user && password_verify($password, $user->getPassword())) {
        $_SESSION['user'] = [
            'id' => $user->getId(),
            'name' => $user->getFirstName(),
            'email' => $user->getEmail(),
            'isAdmin' => $user->getIsAdmin(),
            'cart' => []
        ];

        if ($_SESSION['user']['isAdmin']) {
            header("Location: ../view/admin.php");
            exit();
        } else {
            header("Location: ../view/dishes.view.php");
            exit();
        }
    } else {
        $_SESSION['login_error'] = 'Helytelen email vagy jelszó';
        header("Location: ../view/login.php");
        exit();
    }
} else {
    header("Location: ../view/login.php");
    exit();
}
?>
