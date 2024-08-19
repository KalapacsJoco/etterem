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
