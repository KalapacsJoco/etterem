<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user']);
$userName = $isLoggedIn ? $_SESSION['user']['name'] : '';

// Ellenőrizd, hogy a 'totalItems' be van-e állítva, ha nincs, állítsd be 0-ra
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/etterem/assets/style.css">
</head>

<body class="min-h-screen flex flex-col bg-gray-100 text-gray-100 justify-center" style="background: url('https://img.freepik.com/premium-photo/black-stone-food-background-cooking-ingredients-top-view-free-space-your-text_187166-12991.jpg?w=740') repeat-y center top / 100% auto;">

    <div class="fixed top-0 right-20 h-screen p-4 flex flex-col  items-end bg-transparent text-white">

        <?php if ($isLoggedIn): ?>
            <div class="flex items-center space-x-4">
                <span class="pr-4"><?php echo htmlspecialchars("Üdv újra " . $userName); ?></span>

                <a href="../../includes/logout.php" class="text-red-100 bg-transparent border border-red-100 rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-75 px-6 py-1">Kijelentkezés</a>
            </div>

            <a href="../order.view.php" id="toggleCartButton" class="mt-64 text-grey-100 bg-transparent border border-gray-100 rounded-lg shadow-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75 px-6 py-3">
                Kosár tartalma<span id="cartNumber" class="text-sm">
                    <script>
                        // PHP által generált adat beillesztése egy globális változóba
                        let totalItemsInCart = <?php echo !empty($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'qty')) : 0; ?>;
                    </script>
                </span>
            </a>



        <?php else: ?>
            <a href="../login.php" class="mt-12 text-grey-100 bg-transparent border border-gray-100 rounded-lg shadow-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75 px-6 py-3">Bejelentkezés</a>
            <a href="../register.php" class="mt-12 text-grey-100 bg-transparent border border-gray-100 rounded-lg shadow-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75 px-6 py-3">Regisztrálás</a>
        <?php endif; ?>
    </div>

    <main class="flex-grow flex items-center">
        <?php echo $content; ?>
    </main>

    <footer>
        <p>&copy; 2024 My Website</p>
    </footer>

    <script src="navbar.js"></script>
</body>

</html>