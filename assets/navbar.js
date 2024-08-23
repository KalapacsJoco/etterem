// Váltás a "Kosár tartalma" és a "Vissza az étlapra" gombok között
document.addEventListener('DOMContentLoaded', function() {
    const toggleCartButton = document.getElementById('toggleCartButton');

    // Ellenőrizzük, hogy az oldal tartalmazza-e a 'cart' osztályú elemet
    if (document.querySelector('.cart')) {
        toggleCartButton.innerHTML = 'Vissza az étlapra';
        toggleCartButton.href = "/etterem/view/dishes";  // Átirányítás az étlap oldalra
    }

    // Számolja az aktuális kosár összes tételét
    const cartNumber = document.querySelector('#cartNumber');
    cartNumber.innerHTML = `(${totalItemsInCart})`; // Megjeleníti a kezdeti értéket

    const orderButtons = document.querySelectorAll('.order-button');

    orderButtons.forEach(button => {
        button.addEventListener('click', function () {
            const qtyInput = this.parentElement.querySelector('.qty');
            const quantityToAdd = parseInt(qtyInput.value);

            // Hozzáadjuk a mennyiséget az összesített változóhoz
            totalItemsInCart += quantityToAdd;

            // Frissítjük a kosárban lévő tételek számát a kívánt helyen
            cartNumber.innerHTML = `(${totalItemsInCart})`; // Hozzáad egy zárójeles számot a Kosár tartalma szöveghez
        });
    });
});
