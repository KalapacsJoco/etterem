<?php
include_once 'Database.php';
include_once 'Order.php';
include_once 'User.php';
include_once 'Dish.php';
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

    if ($userId) {
        $total = 0;
        $deliveryType = isset($_POST['delivery_type']) ? $_POST['delivery_type'] : '';
        $deliveryTime = isset($_POST['expected-time']) ? $_POST['expected-time'] : '';

        // Számítsuk ki a teljes összeget
        foreach ($_SESSION['cart'] as $dish) {
            if ($dish instanceof Dish) {
                $total += (int)$dish->getPrice() * $dish->getQty();  // Javítva: $qty -> $dish->getQty()
            }
        }

        // Hozzunk létre egy új Order objektumot és mentsük el a rendelést
        $order = new Order($userId, $dishId, $qty, $deliveryType);

        if ($order->save()) {
            // Rendelési tételek mentése az order_items táblába
            $order->saveOrderItems($_SESSION['cart']);
            $_SESSION['success'] = 'A rendelés és a tételek sikeresen elmentve.';
        } else {
            $_SESSION['error'] = 'Hiba történt a rendelés mentése közben.';
        }
    }
} else {
    echo "gaz van";
}

// Visszairányítjuk a felhasználót az étel oldalára
header("Location: dishes.view.php");
exit();
?>
