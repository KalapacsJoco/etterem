<?php
session_start();
$title = 'Bejelentkezés';
ob_start();
?>

<?php if (isset($_SESSION['login_error'])): ?>
    <div>
        <p><?php echo htmlspecialchars($_SESSION['login_error']); ?></p>
    </div>
    <?php unset($_SESSION['login_error']); ?>
<?php endif; ?>

<form action="/../controllers/login.ctr.php" method="POST" class="w-full max-w-md mx-auto p-6 text-gray-100 pl-4 border border-gray-100 rounded-lg">
    <input type="email" name="email" class="w-full p-2 border border-gray-300 rounded-md caret-amber-100 bg-transparent placeholder-gray-100 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75" placeholder="Add meg az email címed:" required>
    <input type="password" name="password" class="w-full p-2 border border-gray-300 rounded-md caret-amber-100 bg-transparent placeholder-gray-100 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75" placeholder="Add meg a jelszavad:" required>
    <input type="submit" class="w-full p-2 border border-gray-300 rounded-md caret-amber-100 bg-transparent placeholder-gray-100 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75" value="Bejelentkezés">
</form>

<?php
$content = ob_get_clean();
include 'templates/layout.php';
?>
