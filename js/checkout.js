document.addEventListener('DOMContentLoaded', function() {

    function setupForm() {
        var addressForm = document.getElementById('addressForm');
        if (addressForm) {
            addressForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const selectedAddress = document.getElementById('select-address').selectedOptions[0].text;
                displayAddressAndScroll(selectedAddress);
            });
        } else {
            setTimeout(setupForm, 100); // Try again in 100 ms
        }
    }
    setupForm();

    document.getElementById('newAddressForm').addEventListener('submit', function (event) {
        event.preventDefault();
        const formData = new FormData(this);
        const fullname = formData.get('fullname');
        const addressLine1 = formData.get('address_line1');
        const city = formData.get('city');
        const state = formData.get('state');
        const zipCode = formData.get('zip_code');
        const country = formData.get('country');

        fetch('../php/checkout.php', { // Specify the URL to your PHP script
            method: 'POST',
            body: formData
        })
            .then(response => response.text()) // Convert the response to text
            .then(text => {
                console.log(text); // Log the response from the server
                // You can also update the UI here based on the response
            })
            .catch(error => console.error('Error:', error));

        // Validation example
        if (!fullname || !addressLine1 || !city || !state || !zipCode || !country) {
            alert("Please fill in all required fields.");
            return; // Stop the function if validation fails
        }

        const newAddress = `${fullname}, ${addressLine1}, ${formData.get('address_line2') ? formData.get('address_line2') + ', ' : ''}${city}, ${state}, ${zipCode}, ${country}`;
        displayAddressAndScroll(newAddress);
    });

    function displayAddressAndScroll(address) {
        console.log("Selected Address: ", address); // Log the address to console for debugging
        var addressDisplayElement = document.getElementById('addressDisplay');
        if (addressDisplayElement) {
            addressDisplayElement.innerHTML = '<span class="bold">Selected Address:</span> ' + address;
            document.getElementById('addressNotify').textContent = "Payment";
            document.getElementById('totalPrice').style.visibility = "";
            initializePayPalButtons();
            window.scrollTo({top: 0, behavior: 'smooth'});
        } else {
            console.error("Address display element not found"); // Error if element not found
        }
    }

    function initializePayPalButtons() {
        if (window.paypal) {
            paypal.Buttons({
                createOrder: function (data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: document.getElementById('totalAmount').value
                            }
                        }]
                    });
                },
                onApprove: function (data, actions) {
                    return actions.order.capture().then(function (details) {
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
});