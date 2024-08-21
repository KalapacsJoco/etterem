<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<style>
  .horizontal {
    margin-left: calc(100vw * 0.2); /* 20%-os margó a bal oldalon */
    margin-right: calc(100vw * 0.2); /* 20%-os margó a jobb oldalon */
  }
  .vertical {
    height: calc(100vh / 1.5); /* 1.5 elem férjen el egy képernyőn */
  }
</style>

<section class="dishes flex flex-col items-center space-y-4 horizontal vertical">
    <?php if (!empty($dishes) && !empty($images)) : ?>
        <?php foreach ($dishes as $index => $dish) : ?>
            <?php if (isset($images[$index])) : ?>
                <div class="border border-gray-100 text-gray-100  rounded-lg shadow w-auto mx-auto flex">
                    <div class="w-1/2 h-full">
                        <img src="<?php echo htmlspecialchars($images[$index]); ?>" alt="<?php echo htmlspecialchars($dish->name); ?>" class="w-full h-full rounded-2xl object-fill">
                    </div>

                    <div class="w-1/2 pl-4 flex flex-col justify-center items-center">
                        <h2 class="text-xl font-bold mb-2 text-gray-100"><?php echo htmlspecialchars($dish->name); ?></h2>
                        <p class="text-gray-100 mb-2"><?php echo htmlspecialchars($dish->description); ?></p>
                        <p class="text-gray-100 font-bold"><?php echo htmlspecialchars(number_format($dish->price, 2)); ?> Ft</p>

                        <?php
                        $isLoggedIn = isset($_SESSION['user']); // Ellenőrizzük, hogy be van-e jelentkezve a felhasználó
                        $isAdmin = $_SESSION['user']['isAdmin'] ?? false; // Ellenőrizzük, hogy admin-e a felhasználó
                        if (!$isLoggedIn) : ?>
                            <div>
                                Kérünk lépj be vagy regisztrálj a rendeléshez
                            </div>
                        <?php elseif ($isLoggedIn && $isAdmin) : ?>
                            <form action="">
                                <button type="submit" class="text-green-100 bg-transparent border border-green-100 rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-75 px-6 py-3">
                                    Módosítás
                                </button>
                                <form action="../../controllers/order.controller.php">
                                    <button type="submit" class="text-red-100 bg-transparent border border-red-100 rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-75 px-6 py-3">
                                        Törlés
                                    </button>
                                </form>
                            </form>    
                        <?php else : ?>
                            <form method="POST" action="../../controllers/order.controller.php">
                                <input type="hidden" name="dish_id" value="<?php echo $dish->id; ?>">
                                <button  type="submit" class="order-button text-grey-100 bg-transparent border border-gray-100 rounded-lg shadow-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75 px-6 py-1">
                                    Kosárba
                                </button>
                                <input type="number" value="1" name="qty"  min = "1" max = "99" class="qty text-grey-100 bg-transparent border border-gray-100 rounded-lg shadow-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75 px-2 py-1 text-base w-16">
                                <span>db</span>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Nincsenek elérhető ételek.</p>
    <?php endif; ?>
</section>
