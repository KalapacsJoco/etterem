<?php

// Lekérdezzük az aktuális URL-t
$request = $_SERVER['REQUEST_URI'];

// Statikus fájlok közvetlen kiszolgálása
if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js)$/', $request)) {
    $filePath = __DIR__ . $request;
    if (file_exists($filePath)) {
        header("Content-Type: " . mime_content_type($filePath));
        readfile($filePath);
        exit;
    } else {
        http_response_code(404);
        echo "File not found!";
        exit;
    }
}

// A request alapján eldöntjük, melyik fájl szolgálja ki a kérést
switch ($request) {
    case '/':
        require __DIR__ . '/index.php';
        break;

    case '/etterem/login':
        require __DIR__ . '/view/login.php';
        break;

    case '/etterem/register':
        require __DIR__ . '/view/register.php';
        break;

    case '/etterem/view/order':
        require __DIR__ . '/view/order.view.php';
        break;
    case '/etterem/view/dishes':
        require __DIR__ . '/view/dishes.view.php';
        break;
    case '/etterem/view/admin':
        require __DIR__ . '/view/admin.php';
        break;

    case '/etterem/controllers/register':
        require __DIR__ . '/controllers/register.c.php';
        break;
    case '/etterem/controllers/login':
        require __DIR__ . '/controllers/login.ctr.php';
        break;
    case '/etterem/controllers/cart':
        require __DIR__ . '/controllers/cart.controller.php';
        break;
    case '/etterem/controllers/modifyUser':
        require __DIR__ . '/controllers/modifyUser.controller.php';
        break;
    case '/etterem/controllers/order':
        require __DIR__ . '/controllers/order.php';
        break;
    case '/etterem/controllers/admin':
        require __DIR__ . '/controllers/admin.ctr.php';
        break;
    case '/etterem/controllers/dishes':
        require __DIR__ . '/controllers/dishes.controller.php';
        break;

    case '/etterem/includes/logout':
        require __DIR__ . '/includes/logout.php';
        break;
    case '/etterem/includes/deleteDish':
        require __DIR__ . '/includes/deleteDish.php';
        break;

    default:
        // Ha bármilyen más URL van, irányítsd az index.php fájlra
        http_response_code(404);
        echo "Page not found!";
        break;
}
