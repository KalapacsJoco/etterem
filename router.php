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
    case '/etterem/view/dishes' :
        require __DIR__ . '/view/dishes.view.php';
        break;
    case '/etterem/includes/logout' :
        require __DIR__ . '/includes/logout.php';
        break;
    case '/etterem/controllers/register' :
        require __DIR__ . '/controllers/register.c.php';
        break;
    case '/etterem/controllers/cart' :
        require __DIR__ . '/controllers/cart.controller.php';
        break;
    case '/etterem/view/order' :
        require __DIR__ . '/view/order.view.php';
        break;
    case '/etterem/includes/deleteDish' :
        require __DIR__ . '/includes/deleteDish.php';
        break;
    case '/etterem/controllers/order' :
        require __DIR__ . '/controllers/order.php';
        break;


    default:
        // Ha bármilyen más URL van, irányítsd az index.php fájlra
        require __DIR__ . '/indeax.php';
        var_dump(__DIR__);
        break;
}
?>
