// valtakozas felhasznalo frissites form es koras tartalma kozott

document.addEventListener("DOMContentLoaded", function() {
    const modifyForm = document.querySelector('.modifyUser-form');
    const modifyButton = document.querySelector('.modifyUserData-button');
    const userData = document.querySelector('.userData');
    const cart = document.querySelector('.cart');

    // Alapértelmezett állapot: disable a modify form és enable a userData és cart
    modifyForm.style.display = 'none';
    userData.style.display = 'block';
    cart.style.display = 'block';

    // Ha a modify gombra kattintanak
    modifyButton.addEventListener('click', function() {
        modifyForm.style.display = 'block';
        userData.style.display = 'none';
        cart.style.display = 'none';
    });

    // Ha a submit gombra kattintanak
    modifyInput.addEventListener('click', function() {
        modifyForm.style.display = 'none';
        userData.style.display = 'block';
        cart.style.display = 'block';
    });
});

//azonnali osszeg kalkulator

document.addEventListener('DOMContentLoaded', function() {
    // Function to calculate and update the total amount and each item's total price
    function calculateTotal() {
        let totalAmount = 0;
        document.querySelectorAll('.quantity-input').forEach(function(input) {
            const quantity = parseInt(input.value, 10);
            const price = parseInt(input.dataset.price);
            const itemTotal = quantity * price;
            
            // Update the total price for each item in the "Ár" column
            input.closest('tr').querySelector('.item-total').textContent = Math.round(itemTotal) + ' Ft';
            
            totalAmount += itemTotal;
        });
        document.getElementById('totalAmount').textContent = Math.round(totalAmount) + ' Ft';
    }

    // Add event listeners to all quantity input fields
    document.querySelectorAll('.quantity-input').forEach(function(input) {
        input.addEventListener('input', calculateTotal);
    });
});

// Becsult elkeszulesi ido kiszamitasa

document.addEventListener('DOMContentLoaded', function() {
    // Function to update the expected preparation time
    function updateExpectedTime() {
        const currentTime = new Date();
        const deliveryType = document.querySelector('input[name="delivery_type"]:checked').value;
        let expectedTime;

        if (deliveryType === 'delivery') {
            currentTime.setHours(currentTime.getHours() + 1);  // Add 1 hour for home delivery
        } else if (deliveryType === 'pickup') {
            currentTime.setMinutes(currentTime.getMinutes() + 30);  // Add 30 minutes for pickup
        }

        expectedTime = currentTime.toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'});
        document.getElementById('expected-time').textContent = expectedTime;
    }

    // Set initial expected time on page load
    updateExpectedTime();

    // Add event listeners to radio buttons to update time on change
    document.querySelectorAll('input[name="delivery_type"]').forEach(function(input) {
        input.addEventListener('change', updateExpectedTime);
    });
});
