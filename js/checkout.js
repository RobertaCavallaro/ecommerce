document.getElementById('addressForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission
    const selectedAddress = document.getElementById('select-address').selectedOptions[0].text;
    displayAddressAndScroll(selectedAddress);
});

document.getElementById('newAddressForm').addEventListener('submit', function(event) {
    event.preventDefault();
    // Create a FormData object, passing in the form
    const formData = new FormData(this);

    // Retrieve each form field by its 'name' attribute and store each in a variable
    const fullname = formData.get('fullname');
    const addressLine1 = formData.get('address_line1');
    const addressLine2 = formData.get('address_line2');
    const city = formData.get('city');
    const state = formData.get('state');
    const zipCode = formData.get('zip_code');
    const country = formData.get('country');
    // Assume here you collect the data and create a readable format
    const newAddress = `${fullname}, ${addressLine1}, ${addressLine2 ? addressLine2 + ', ' : ''}${city}, ${state}, ${zipCode}, ${country}`;

    displayAddressAndScroll(newAddress);
});

function displayAddressAndScroll(address) {
    console.log("Selected Address: ", address); // Log the address to console for debugging
    var addressDisplayElement = document.getElementById('addressDisplay');
    if (addressDisplayElement) {
        addressDisplayElement.innerHTML = '<span class="bold">Selected Address:</span> ' + address;
        document.getElementById('addressNotify').textContent = "Payment";
        initializePayPalButtons();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    } else {
        console.error("Address display element not found"); // Error if element not found
    }
}

function initializePayPalButtons() {
    if (window.paypal) {
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?= $total_amount ?>'
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    alert('Transaction completed by ' + details.payer.name.given_name);
                    // You can add additional logic here for what happens after payment is confirmed
                });
            }
        }).render('#paypal-button-container');
    } else {
        // Retry initialization if PayPal is not loaded yet
        setTimeout(initializePayPalButtons, 500);
    }
}
