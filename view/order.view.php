<?php
include_once __DIR__ . '/../models/Dish.php';  // a __DIR__ a jelenlegi mappa (controllers) útvonalát adja
include_once __DIR__ . '/../models/User.php';  // a __DIR__ a jelenlegi mappa (controllers) útvonalát adja
session_start();
$userId = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null;
$user = $userId ? User::findById($userId) : null;

$items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$totalItems = 0;
$_SESSION['totalItems'] = $totalItems;  // Módosítva 'totalItems' helyesen

$title = 'Kosár tartalma';
ob_start();
?>

<div class="flex w-full text-gray-100 mt-32 items-start">
    <div class="cart  pr-4">
        <h2 class="text-xl font-bold mb-4">Kosár tartalma</h2>

        <?php if (!empty($items)) : ?>
            <table class="min-w-75 bg-gray">
                <thead>
                    <tr>
                        <th class="py-2">Név</th>
                        <th class="py-2">Mennyiség</th>
                        <th class="py-2">Ár</th>
                    </tr>
                </thead>
                <tbody class="border border-gray-300 rounded-lg">
                    <?php
                    foreach ($items as $item) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item->getName()); ?></td>
                            <td>
                                <form action="../controllers/order.controller.php" method= "POST" >
                                    <input name="qty" class="w-16 caret-amber-100 bg-transparent placeholder-gray-100 text-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75 quantity-input text-center" 
                                    type="number" value="<?php echo htmlspecialchars($item->getQty()); ?>" min="0" max="99" data-price="<?php echo $item->getPrice(); ?>" data-item-total>
                                </form>
                            </td>


                            <td class="item-total" data-item-total-price>
                                <?php echo htmlspecialchars(number_format(round($item->getPrice() * $item->getQty()), 0, '', '')); ?> Ft
                            </td>

                            <td>
                                <form action="/etterem/includes/deleteDish" method="POST">
                                <input type="hidden" name="delete_dish_id" value="<?php echo $item->getId(); ?>">
                                <button type="submit" name="deleteDish" class="text-red-100 bg-transparent border border-red-500 rounded-lg shadow hover:bg-red-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-75 px-4  ml-4 my-2 transition-colors duration-200">
                                    Törlés
                                </button>
                                </form>
                            </td>



                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="flex justify-between">
            <h3 class="text-xl font-bold ">Összeg:</h3>
            <span id="totalAmount" class="font-bold text-lg">
                <?php
                $totalAmount = 0;
                foreach ($items as $item) {
                    $totalAmount += ($item->getPrice() * $item->getQty());
                }
                echo htmlspecialchars(number_format($totalAmount, 0));
                ?> Ft
            </span> <br>
            </div>

        <form action="/etterem/controllers/order" method= "POST" >
            <label class="inline-flex items-center">
                <input type="radio" name="delivery_type" value="delivery" class="form-checkbox" checked>
                <span class="ml-2">Házhoz kérem</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="delivery_type" value="pickup" class="form-checkbox">
                <span class="ml-2">Elveszem az étteremből</span>
            </label>
            <br>
            <h4>Elkészülés várható ideje: <span id="expected-time" class="font-bold text-lg"></span></h4>
            <br>
            <div class="flex justify-center mt-6">
                <input type="submit" value="Megrendelem" class="text-green-100 bg-transparent border border-green-100 rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-75 px-6 py-3">
            </div>
            </form>
    </div>

    <div class="userData w-auto h-auto pl-4 border border-gray-100 rounded-lg sticky top-1/2 transform -translate-y-1/2">
        <table>
            <h2 class="text-xl font-bold mb-4">Felhasználó adatai</h2>
            <tr>
                <td>Felhasználó neve:</td>
                <td class="px-4 py-2"><?php echo htmlspecialchars($user->getFirstName() . ' ' . $user->getLastName()); ?></td>
            </tr>
            <tr>
                <td>Telefonszám:</td>
                <td class="px-4 py-2"><?php echo htmlspecialchars($user->getPhone()); ?></td>
            </tr>
            <tr>
                <td>Utca:</td>
                <td class="px-4 py-2"><?php echo htmlspecialchars($user->getStreet()); ?></td>
            </tr>
            <tr>
                <td>Házszám:</td>
                <td class="px-4 py-2"><?php echo htmlspecialchars($user->getHouseNumber()); ?></td>
            </tr>
            <tr>
                <td colspan="2" class="text-center">
                    <button class="modifyUserData-button text-grey-100 bg-transparent border border-gray-100 rounded-lg shadow-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75 px-2 py-1"> Adataim módosítása </button>
                </td>
            </tr>
        </table>
    </div>
</div>

<?php if (!empty($errors)): ?>
    <div>
        <?php foreach ($errors as $error): ?>
            <p><?php echo htmlspecialchars($error); ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form class="modifyUser-form" action="../controllers/modifyUser.controller.php" method="POST">
    <label for="firstName">Vezetéknév:</label>
    <input class="modifyInput" type="text" name="firstName" value="<?php echo htmlspecialchars($user->getFirstName()); ?>"><br>

    <label for="lastName">Keresztnév:</label>
    <input class="modifyInput" type="text" name="lastName" value="<?php echo htmlspecialchars($user->getLastName()); ?>"><br>

    <label for="phoneNumber">Telefonszám:</label>
    <input class="modifyInput" type="number" name="phoneNumber" value="<?php echo htmlspecialchars($user->getPhone()); ?>"><br>

    <label for="street">Utca:</label>
    <input class="modifyInput" type="text" name="street" value="<?php echo htmlspecialchars($user->getStreet()); ?>"><br>

    <label for="houseNumber">Házszám:</label>
    <input class="modifyInput" type="houseNumber" name="houseNumber" value="<?php echo htmlspecialchars($user->getHouseNumber()); ?>"><br>

    <input class="modifyInput" type="submit" value="Módosítás">
</form>
<script src="/etterem/view/order.view.js"></script>




<?php else : ?>
    <p>Nincs termék a kosárban.</p>
<?php endif; ?>

<?php
$content = ob_get_clean();
include 'templates/layout.php';
?>