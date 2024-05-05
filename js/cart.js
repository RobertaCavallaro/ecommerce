document.addEventListener('DOMContentLoaded', function() {
    // This function updates the quantity in the input field
    function updateQuantity(input, increment) {
        let currentValue = parseInt(input.value);
        let newValue = currentValue + increment;

        // Ensure the quantity never goes below 1
        if (newValue < 1) newValue = 1;

        input.value = newValue; // Set the new value in the input field
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

    searchButton.addEventListener('click', function(event) {
        event.preventDefault();
        let searchValue = searchInput.value.toLowerCase();
        let hasMatch = false;
        // Hide all rows and columns initially
        const rows = document.querySelectorAll('.product-row'); // Assuming your products are wrapped in elements with class 'product-row'
        document.getElementById('load-more').style.display = 'none';
        rows.forEach(row => {
            row.style.display = 'none'; // Hide each row initially
            const columns = row.querySelectorAll('.product-column'); // Assuming products are further organized in columns
            columns.forEach(column => {
                column.style.display = 'none'; // Hide each column initially
            });
        });

        productCards.forEach(card => {
            const name = card.getAttribute('data-name').toLowerCase();
            const description = card.getAttribute('data-description').toLowerCase();
            if (name.includes(searchValue) || description.includes(searchValue)) {
                card.style.display = ''; // Show matching card
                card.closest('.product-column').style.display = ''; // Show the column of the matching card
                card.closest('.product-row').style.display = ''; // Show the row of the matching card
                hasMatch = true;
            } else {
                card.style.display = 'none'; // Hide non-matching card
            }
        });
        if (hasMatch) {
            window.scrollTo({
                top: productSection.offsetTop,
                behavior: 'smooth'
            });
        }
    });

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

        productCards.forEach(card => {
            const productGender = card.getAttribute('data-gender');
            const productSeason = card.getAttribute('data-season');
            const productPrice = parseFloat(card.getAttribute('data-price'));

            let genderMatch = genders.length === 0 || genders.includes(productGender);
            let seasonMatch = seasons.length === 0 || seasons.includes(productSeason);
            let priceMatch = productPrice <= parseFloat(priceRange);


            if (genderMatch && seasonMatch && priceMatch) {
                card.style.display = '';  // Show the card
                card.closest('.product-column').style.display = ''; // Show the column of the matching card
                card.closest('.product-row').style.display = '';
            } else {
                card.style.display = 'none';  // Hide the card
            }
        });
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

});

