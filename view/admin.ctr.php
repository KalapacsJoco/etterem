<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include_once 'Database.php';
include_once 'Dish.php';

if (!isset($_SESSION['user']) || !$_SESSION['user']['isAdmin']) {
    header("Location: index.php");
    exit();
}

$errors = [];
$name = $description = $price = '';

// Ellenőrizzük, hogy az /img/foods könyvtár létezik-e, és ha nem, hozzuk létre
$uploadDir = 'img/foods/';
if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0777, true)) {
        $errors[] = 'Nem sikerült létrehozni az img/foods könyvtárat.';
        error_log('Nem sikerült létrehozni az img/foods könyvtárat: ' . $uploadDir);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST["name"]) ? trim($_POST["name"]) : '';
    $description = isset($_POST["description"]) ? trim($_POST["description"]) : '';
    $price = isset($_POST["price"]) ? trim($_POST["price"]) : '';

    if (empty($name)) {
        $errors[] = 'Az étel neve megadása kötelező';
    }
    if (empty($description)) {
        $errors[] = 'Az étel leírása megadása kötelező';
    }
    if (empty($price)) {
        $errors[] = 'Az étel ára megadása kötelező';
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $imageType = mime_content_type($image['tmp_name']);

        if (!in_array($imageType, $allowedTypes)) {
            $errors[] = 'Csak JPEG, PNG vagy GIF fájlok tölthetők fel.';
        } else {
            $imagePath = $uploadDir . basename($image['name']);

            if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
                $errors[] = 'Hiba történt a kép feltöltése során';
                error_log('Fájl feltöltési hiba: ' . print_r($_FILES, true));
            } else {
                error_log('Fájl sikeresen feltöltve: ' . $imagePath);
            }
        }
    } else {
        $errors[] = 'Kép feltöltése sikertelen. Kérjük, próbálja újra. Hiba: ' . (isset($_FILES['image']) ? $_FILES['image']['error'] : 'Fájl nem lett feltöltve');
        error_log('Kép feltöltési hiba: ' . print_r($_FILES, true));
    }

    if (empty($errors)) {
        $dish = new Dish($name, $description, $price);

        if ($dish->save()) {
            $_SESSION['success'] = 'Az étel sikeresen létrehozva';
            header("Location: admin.php");
            exit();
        } else {
            $errors[] = 'Hiba történt az étel létrehozása során';
        }
    }

    if (!empty($errors)) {
        echo "<pre>";
        print_r($_FILES);
        print_r($_SESSION);
        echo "</pre>";
        $_SESSION['errors'] = $errors;
        header("Location: admin.php");
        exit();
    }
    
} else {
   var_dump($errors);
    exit();
}
?>
