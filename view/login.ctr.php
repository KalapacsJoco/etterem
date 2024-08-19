<?php
session_start();
include_once 'Database.php';
include_once 'User.php';

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
            header("Location: admin.php");
            exit();
        } else {
            header("Location: dishes.view.php");
            exit();
        }
    } else {
        $_SESSION['login_error'] = 'Helytelen email vagy jelszó';
        header("Location: login.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>
