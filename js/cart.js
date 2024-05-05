document.addEventListener('DOMContentLoaded', function() {
    // This function updates the quantity in the input field
    function updateQuantity(input, increment) {
        let currentValue = parseInt(input.value);
        let newValue = currentValue + increment;

        // Ensure the quantity never goes below 1
        if (newValue < 1) newValue = 1;

        input.value = newValue; // Set the new value in the input field
    }

    if (isLoggedIn) {
        fetchAndUpdateCartCount();
    }

    // Add event listeners to all + and - buttons
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            const inputField = this.parentElement.querySelector('.quantity');
            const increment = this.classList.contains('plus-btn') ? 1 : -1;
            updateQuantity(inputField, increment);
        });
    });

    const searchInput = document.getElementById('custom-search-bar');
    const productSection = document.getElementById('products');
    const productCards = document.querySelectorAll('.product-card');
    const searchButton = document.getElementById('searchButton');
    const btnApplyFilters = document.getElementById('apply-filters');
    const cartItemCount = document.getElementById('cartItemCount');

    searchButton.addEventListener('click', function(event) {
        event.preventDefault();
        let searchValue = searchInput.value.toLowerCase();
        let hasMatch = false;
        // Hide all rows and columns initially
        const rows = document.querySelectorAll('.product-row'); // Assuming your products are wrapped in elements with class 'product-row'
        document.getElementById('load-more').style.display = 'none';
        const container = document.getElementById('products');
        container.innerHTML = ''; // Clear the existing content.
        let newRow = createRow(); // Create the first row.
        container.appendChild(newRow);
        let index=0;

        productCards.forEach(card => {
            const name = card.getAttribute('data-name').toLowerCase();
            const description = card.getAttribute('data-description').toLowerCase();
            if (name.includes(searchValue) || description.includes(searchValue)) {
                if (index % 3 === 0 && index !== 0) { // Every 3 cards, start a new row.
                    newRow = createRow();
                    container.appendChild(newRow);
                }
                const column = createColumn(); // Create a new column for each card.
                column.appendChild(card);
                newRow.appendChild(column);// Show the row of the matching card
                hasMatch = true;
                index +=1;
            }
        });
        if (hasMatch) {
            window.scrollTo({
                top: productSection.offsetTop,
                behavior: 'smooth'
            });
        }
    });

    function rearrangeProducts() {
        const container = document.getElementById('products'); // This is the main container where product rows are placed.
        const allCards = Array.from(document.querySelectorAll('.product-card')); // Get all product cards.
        const visibleCards = allCards.filter(card => card.style.display !== 'none'); // Filter out visible cards.

        container.innerHTML = ''; // Clear the existing content.
        let newRow = createRow(); // Create the first row.
        container.appendChild(newRow);

        visibleCards.forEach((card, index) => {
            if (index % 3 === 0 && index !== 0) { // Every 3 cards, start a new row.
                newRow = createRow();
                container.appendChild(newRow);
            }
            const column = createColumn(); // Create a new column for each card.
            column.appendChild(card);
            newRow.appendChild(column);
        });
    }

    function createRow() {
        const row = document.createElement('div');
        row.className = 'row product-row';
        return row;
    }

    function createColumn() {
        const column = document.createElement('div');
        column.className = 'col-md-4 mb-4 product-column';
        return column;
    }


    btnApplyFilters.addEventListener('click', function() {
        // Gather checked genders
        const genders = [];
        ['male', 'female', 'unisex'].forEach(gender => {
            const checkbox = document.getElementById(gender);
            if (checkbox.checked) {
                genders.push(gender);
            }
        });

        // Gather checked seasons
        const seasons = [];
        ['summer', 'spring', 'autumn', 'winter'].forEach(season => {
            const checkbox = document.getElementById(season);
            if (checkbox.checked) {
                seasons.push(season);
            }
        });
        const priceRange = document.getElementById('price-range').value;

        const rows = document.querySelectorAll('.product-row');
        rows.forEach(row => {
            row.style.display = 'none'; // Hide each row initially
            const columns = row.querySelectorAll('.product-column'); // Assuming products are further organized in columns
            columns.forEach(column => {
                column.style.display = 'none'; // Hide each column initially
            });
        });
        const container = document.getElementById('products');
        container.innerHTML = ''; // Clear the existing content.
        let newRow = createRow(); // Create the first row.
        container.appendChild(newRow);
        let index = 0;
        productCards.forEach(card => {
            const productGender = card.getAttribute('data-gender');
            const productSeason = card.getAttribute('data-season');
            const productPrice = parseFloat(card.getAttribute('data-price'));

            let genderMatch = genders.length === 0 || genders.includes(productGender);
            let seasonMatch = seasons.length === 0 || seasons.includes(productSeason);
            let priceMatch = productPrice <= parseFloat(priceRange);

            if (genderMatch && seasonMatch && priceMatch) {
                if (index % 3 === 0 && index !== 0) { // Every 3 cards, start a new row.
                    newRow = createRow();
                    container.appendChild(newRow);
                }
                const column = createColumn(); // Create a new column for each card.
                column.appendChild(card);
                newRow.appendChild(column);
                index +=1;
            }
        });
        rearrangeProducts();
    });
    const priceRange = document.getElementById('price-range');
    const priceDisplay = document.getElementById('price-display');

    // Function to update the displayed price
    function updatePriceDisplay() {
        priceDisplay.textContent = '$' + priceRange.value;
    }

    // Initialize with the default value
    updatePriceDisplay();

    // Add event listener to update display on slider change
    priceRange.addEventListener('input', updatePriceDisplay);

    // Season images clickable
    document.querySelectorAll('.season-image').forEach(imageDiv => {
        imageDiv.addEventListener('click', function() {
            const clickedSeason = this.getAttribute('data-season');
            const allSeasons = ['summer', 'spring', 'autumn', 'winter']; // List all possible seasons

            allSeasons.forEach(season => {
                const checkbox = document.getElementById(season);
                if (checkbox) {
                    checkbox.checked = (season === clickedSeason); // Check only the clicked season, uncheck others
                }
            });

            // Automatically click the apply filters button to update the results
            document.getElementById('apply-filters').click();
        });
    });
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            if (!isLoggedIn) {
                event.preventDefault();  // Prevent the cart operation
                showLoginModal();        // Show login modal
            } else {
                // Proceed with adding to cart
                const productId = this.parentElement.parentElement.getAttribute('data-product-id');
                const quantity = this.parentElement.querySelector('.quantity').value; // This can be dynamic based on user input if needed
                fetch('php/cart.php', {
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
                    })
                    .catch(error => console.error('Error:', error));
            }
        });
    });

    // Function to fetch and update the cart item count
    function fetchAndUpdateCartCount() {
        fetch('php/cart.php?action=getItemCount')
            .then(response => response.json())
            .then(data => {
                cartItemCount.textContent = data.count; // Assuming the response includes { count: X }
            })
            .catch(error => console.error('Error:', error));
    }

    function showLoginModal() {
        // Code to display your login modal
        $('#loginModal').modal('show'); // Example using Bootstrap modal
    }

});





