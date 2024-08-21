<?php
include_once __DIR__ . '/../models/Database.php';  // a __DIR__ a jelenlegi mappa (controllers) útvonalát adja
include_once __DIR__ . '/../models/Dish.php';  // a __DIR__ a jelenlegi mappa (controllers) útvonalát adja
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['dish_id'])) {
    $userId = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null;
    $dishId = $_POST['dish_id'];  // Javítva: dishId -> dish_id
    $qty = $_POST['qty'];

    // Keressük meg az ételt az adatbázisban az ID alapján
    $dish = Dish::findById($dishId);
    
    if ($dish) {
        $dish->setQty($qty);  // Csak akkor fut, ha a $dish nem null
        $found = false;
    
        // Ellenőrizzük, hogy az étel már létezik-e a kosárban
        foreach ($_SESSION['cart'] as $key => $existingDish) {
            if ($existingDish->id == $dish->id) {
                // Ha már létezik, növeljük a mennyiséget
                $existingDish->setQty($existingDish->getQty() + $dish->getQty());
                $found = true;
                break;
            }
        }
    
        // Ha nem találta meg, akkor hozzáadjuk a kosárhoz
        if (!$found) {
            $_SESSION['cart'][] = $dish;
        }
    
        $_SESSION['success'] = 'Az étel sikeresen hozzáadva a kosárhoz.';
    } else {
        $_SESSION['error'] = 'Az étel nem található.';
    }
} else {
    echo "gaz van";
}

// Visszairányítjuk a felhasználót az étel oldalára
header("Location: /etterem/view/dishes");
exit();
?>