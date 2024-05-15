document.addEventListener('DOMContentLoaded', function() {
    const productName = document.getElementById('productName');
    const productDescription = document.getElementById('productDescription');
    const productPrice = document.getElementById('productPrice');
    const productImage = document.getElementById('productImage');
    const productQuantity = document.getElementById('productQuantity');
    const addToCartBtn = document.getElementById('addToCartBtn');
    const cartItemCount = document.getElementById('cartItemCount');

    // Extract product ID from URL
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('id');

    // Handle quantity increase/decrease
    document.getElementById('increaseQuantity').addEventListener('click', () => {
        productQuantity.value = parseInt(productQuantity.value) + 1;
    });

    document.getElementById('decreaseQuantity').addEventListener('click', () => {
        if (productQuantity.value > 1) {
            productQuantity.value = parseInt(productQuantity.value) - 1;
        }
    });

    const addToCartButtons = document.querySelectorAll('#addToCartBtn');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            // Proceed with adding to cart
            const productId = document.querySelector('#productQuantity').getAttribute('data-product-id');
            const quantity = document.querySelector('#productQuantity').value; // This can be dynamic based on user input if needed
            fetch('cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=add&productId=${productId}&quantity=${quantity}`
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    fetchAndUpdateCartCount();
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                })
                .catch(error => console.error('Error:', error));
        });
    });
    // Function to fetch and update the cart item count
    function fetchAndUpdateCartCount() {
        fetch('cart.php?action=getItemCount')
            .then(response => response.json())
            .then(data => {
                cartItemCount.textContent = data.count; // Assuming the response includes { count: X }
            })
            .catch(error => console.error('Error:', error));
    }

    fetchAndUpdateCartCount();
});
