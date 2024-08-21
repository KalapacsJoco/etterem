<?php
session_start();
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$inputValues = isset($_SESSION['inputValues']) ? $_SESSION['inputValues'] : [];
unset($_SESSION['errors'], $_SESSION['inputValues']);

$title = 'Regisztráció';
ob_start();
?>

<?php if (!empty($errors)): ?>
    <div>
        <?php foreach ($errors as $error): ?>
            <p><?php echo htmlspecialchars($error); ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form action="/etterem/controllers/register" method="POST" class="w-full max-w-md mx-auto p-6 text-gray-100 pl-4 border border-gray-100 rounded-lg">
    <input type="text" name="firstName" class="w-full p-2 border border-gray-300 rounded-md caret-amber-100 bg-transparent placeholder-gray-100 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75" placeholder="Vezetéknév:" value="<?php echo htmlspecialchars($inputValues['firstName'] ?? ''); ?>">
    <input type="text" name="lastName" class="w-full p-2 border border-gray-300 rounded-md caret-amber-100 bg-transparent placeholder-gray-100 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75" placeholder="Keresztnév:" value="<?php echo htmlspecialchars($inputValues['lastName'] ?? ''); ?>">
    <input type="email" name="email" class="w-full p-2 border border-gray-300 rounded-md caret-amber-100 bg-transparent placeholder-gray-100 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75" placeholder="Add meg az email címed:" value="<?php echo htmlspecialchars($inputValues['email'] ?? ''); ?>">
    <input type="password" name="pwd" class="w-full p-2 border border-gray-300 rounded-md caret-amber-100 bg-transparent placeholder-gray-100 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75" placeholder="Add meg a jelszavad:">
    <input type="password" name="newPwd" class="w-full p-2 border border-gray-300 rounded-md caret-amber-100 bg-transparent placeholder-gray-100 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75" placeholder="Jelszó újra:">
    <input type="tel" name="phone" class="w-full p-2 border border-gray-300 rounded-md caret-amber-100 bg-transparent placeholder-gray-100 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75" placeholder="Telefonszám:" value="<?php echo htmlspecialchars($inputValues['phone'] ?? ''); ?>">
    <input type="text" name="street" class="w-full p-2 border border-gray-300 rounded-md caret-amber-100 bg-transparent placeholder-gray-100 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75" placeholder="Utca:" value="<?php echo htmlspecialchars($inputValues['street'] ?? ''); ?>">
    <input type="number" name="houseNumber" class="w-full p-2 border border-gray-300 rounded-md caret-amber-100 bg-transparent placeholder-gray-100 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75" placeholder="Házszám:" value="<?php echo htmlspecialchars($inputValues['houseNumber'] ?? ''); ?>">
    <label for="terms">Elfogadom a felhasználói feltételeket</label>
    <input type="checkbox" id="terms" name="terms" <?php echo isset($inputValues['terms']) ? 'checked' : ''; ?>><br><br>
    <input type="submit" class="text-grey-100 bg-transparent border border-gray-100 rounded-lg shadow-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75 px-6 py-3" value="Regisztrálok">
</form>

<?php
$content = ob_get_clean();
include 'templates/layout.php';
?>
