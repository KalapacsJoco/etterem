<?php
session_start();
include_once __DIR__ . '/../models/Database.php';  // a __DIR__ a jelenlegi mappa (controllers) útvonalát adja
include_once __DIR__ . '/../models/User.php';


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
            header("Location: /etterem/view/admin");
            exit();
        } else {
            header("Location: /etterem/view/dishes");
            exit();
        }
    } else {
        $_SESSION['login_error'] = 'Helytelen email vagy jelszó';
        header("Location: /etterem/view/login");
        exit();
    }
} else {
    header("Location: /etterem/view/login");
    exit();
}
?>
