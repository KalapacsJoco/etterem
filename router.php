<?php
// router.php

// Lekérdezzük az aktuális URL-t
$request = $_SERVER['REQUEST_URI'];


// A request alapján eldöntjük, melyik fájl szolgálja ki a kérést
switch ($request) {
    case '/' :
        require __DIR__ . '/index.php';
        break;
    case '/etterem/login' :
        require __DIR__ . '/view/login.php';
        break;
    case '/etterem/register' :
        require __DIR__ . '/view/register.php';
        break;
    case '/etterem/controllers/login' :
        require __DIR__ . '/controllers/login.ctr.php';
        break;
    default:
        // Ha bármilyen más URL van, irányítsd az index.php fájlra
        require __DIR__ . '/indaex.php';
        break;
}
?>
