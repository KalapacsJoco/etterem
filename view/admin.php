<?php
include_once '../models/Dish.php';
$title = 'Admin Page';
ob_start();

$imageDir = 'img/foods/';
$images = glob($imageDir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

// Feltételezzük, hogy a $dishes változó már fel van töltve ételekkel, például az adatbázisból
$dishes = Dish::findAll(); // Ez egy példa arra, hogyan lehet lekérni az összes ételt
?>
<button id="toggleFormButton"  class="fixed top-64 left-0 text-grey-100 bg-transparent border border-gray-100 rounded-lg shadow-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75 px-6 py-3">
    Új eledel felvétele
</button>
<form id="foodForm" action="../controllers/admin.ctr.php" method="POST" enctype="multipart/form-data" class=" hidden w-full max-w-md mx-auto p-6 text-gray-100 pl-4 border border-gray-100 rounded-lg">
    <div class="mb-4">
        <label for="name" class="w-full p-2 caret-amber-100 bg-transparent placeholder-gray-100">Étel neve:</label>
        <input type="text" name="name" id="name" class="w-full p-2 border border-gray-300 rounded-md caret-amber-100 bg-transparent placeholder-gray-100 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75" required>
    </div>
    <div class="mb-4">
        <label for="description" class="w-full p-2 caret-amber-100 bg-transparent placeholder-gray-100">Leírás:</label>
        <textarea name="description" id="description" class="w-full p-2 border border-gray-300 rounded-md caret-amber-100 bg-transparent placeholder-gray-100 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75" required></textarea>
    </div>
    <div class="mb-4">
        <label for="price" class="w-full p-2 caret-amber-100 bg-transparent placeholder-gray-100">Ár:</label>
        <input type="number" name="price" id="price" step="0.01" class="w-full p-2 border border-gray-300 rounded-md caret-amber-100 bg-transparent placeholder-gray-100 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75" required>
    </div>
    <div class="mb-4">
        <label for="fileInput" class="w-full p-2 caret-amber-100 bg-transparent placeholder-gray-100">Kép feltöltése:</label> <br>
        <div class="relative inline-block">
            <button type="button" class="text-grey-100 bg-transparent border border-gray-100 rounded-lg shadow-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75 px-6 py-3">
                Fájl kiválasztása
            </button>
            <input type="file" id="fileInput" class="opacity-0 absolute inset-0 w-full h-full cursor-pointer" onchange="updateFileName()" />
            <span id="fileName" class="ml-4 text-gray-300">Nincs fájl kiválasztva</span>
        </div>
    </div>
    <div class="flex items-center justify-between">
        <input type="submit" class="text-grey-100 bg-transparent border border-gray-100 rounded-lg shadow-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75 px-6 py-3" value="Létrehozás">
    </div>
    <script>
        function updateFileName() {
            const input = document.getElementById('fileInput');
            const fileName = document.getElementById('fileName');

            if (input.files.length > 0) {
                fileName.textContent = input.files[0].name;
            } else {
                fileName.textContent = 'Nincs fájl kiválasztva';
            }
        }
    </script>
</form>
<?php
include_once 'templates/dishCard.php';
$content = ob_get_clean();
include 'templates/layout.php';
?>
<script>
    document.getElementById('toggleFormButton').addEventListener('click', function() {
        const dishesSection = document.querySelector('.dishes');
        const foodForm = document.getElementById('foodForm');
        const buttontext = document.querySelector('#toggleFormButton');

        // Toggle the visibility of the dishes section and the form
        if (dishesSection.classList.contains('hidden')) {
            buttontext.innerHTML = 'Új eledel hozzáadása'; // Amikor a form rejtve van
            dishesSection.classList.remove('hidden');
            foodForm.classList.add('hidden');
        } else {
            buttontext.innerHTML = 'Vissza a szerkesztéshez'; // Amikor a form látható
            dishesSection.classList.add('hidden');
            foodForm.classList.remove('hidden');
        }
    });
</script>
