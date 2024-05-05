document.addEventListener('DOMContentLoaded', function() {

    function updateCart(action,productId, quantity) {
        fetch('cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=${action}&productId=${productId}&quantity=${quantity}`
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.message === "Cart updated successfully") {
                    window.location.reload(); // Reload the page if the update is successful
                } else {
                    alert('Failed to update cart. Please try again.'); // Alert if the update failed
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating cart. Please try again.'); // Alert on fetch error
                window.location.reload();
            });
    }

    // Handle quantity changes
    document.querySelectorAll('.plus-btn').forEach(button => {
        button.addEventListener('click', function() {
            const quantityInput = this.parentNode.querySelector('.quantity');
            const productId = this.getAttribute('data-id');
            const quantity = parseInt(quantityInput.value) + 1; // Increment the quantity
            quantityInput.value = quantity; // Update the input field with new quantity

            if (!isLoggedIn) {
                window.location.href = '/php/login.php'; // Redirect to login if not logged in
            } else {
                updateCart("update",productId, quantity);
            }
        });
    });


    document.querySelectorAll('.minus-btn').forEach(button => {
        button.addEventListener('click', function() {
            const quantityInput = this.parentNode.querySelector('.quantity');
            const productId = this.getAttribute('data-id');
            const quantity = parseInt(quantityInput.value) - 1; // decrement the quantity
            quantityInput.value = quantity; // Update the input field with new quantity

            if (!isLoggedIn) {
                window.location.href = '/php/login.php'; // Redirect to login if not logged in
            } else {
                updateCart("update",productId, quantity);
            }
        });
    });

    // Handle item deletion
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const quantityInput = this.parentNode.querySelector('.quantity');
            const productId = this.getAttribute('data-id');
            const quantity = parseInt(quantityInput.value);
            quantityInput.value = quantity; // Update the input field with new quantity

            if (!isLoggedIn) {
                window.location.href = '/php/login.php'; // Redirect to login if not logged in
            } else {
                updateCart("delete",productId, quantity);
            }
        });
    });
});
