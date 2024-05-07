<?php
session_start();

include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$conn = new mysqli($servername, $username, $password, $dbname, $port);
// Fetch existing addresses
$addresses = [];
$sql = "SELECT * FROM addresses WHERE customer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $addresses[] = $row;
}
$stmt->close();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_address'])) {
    $fullname = $_POST['fullname'];
    $address_line1 = $_POST['address_line1'];
    $address_line2 = $_POST['address_line2'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip_code = $_POST['zip_code'];
    $country = $_POST['country'];

    $sql = "INSERT INTO addresses (customer_id, fullname, address_line1, address_line2, city, state, zip_code, country)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssis", $user_id, $fullname, $address_line1, $address_line2, $city, $state, $zip_code, $country);

    if ($stmt->execute()) {
        echo "Address saved successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Dummy total amount for the example
$total_amount = $_SESSION['total_amount']; // This should be the total amount from the cart

// Dummy client-side implementation for PayPal
$paypalClientId = 'ATxEnEoBxidA9z9SK_J_8SkR5rjcvWhFg-kmtSbaV7Ir44waIVtQ141SG-hItI9kbqGVwVS6A6LuJNMH'; // Replace with your actual PayPal Client ID
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <!-- Include Bootstrap CSS for responsiveness and styling -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Styles for a more polished look -->
    <link rel="stylesheet" href="/css/checkout.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=<?= $paypalClientId ?>&currency=USD"></script>

</head>
<body>
<div class="container">
    <div class="header">
        <h1 class="modal-title">Checkout</h1>
    </div>
    <div class="row">
        <div class="col-md-6">
            <!-- Form to Add or Select Address -->
            <h2>Shipping Address</h2>
            <?php if (!empty($addresses)): ?>
                <form action="checkout.php" class="address-form" id="addressForm" method="post">
                    <div class="form-group">
                        <label for="select-address">Select an existing address:</label>
                        <select class="form-control" id="select-address" name="address_id">
                            <?php foreach ($addresses as $address): ?>
                                <option value="<?= $address['id'] ?>">
                                    <?= htmlspecialchars($address['fullname']) . ", " . htmlspecialchars($address['address_line1']) . ", " . htmlspecialchars($address['address_line2']) . ", " . htmlspecialchars($address['city']) . ", " . htmlspecialchars($address['state']) . ", " . htmlspecialchars($address['zip_code']) . ", " . htmlspecialchars($address['country']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Use this Address</button>
                </form>
            <?php endif; ?>
            <form action="checkout.php" class="address-form" id="newAddressForm" method="post">
                <label for="select-address" style="margin-bottom: 20px">OR save a new address:</label>
                <input type="hidden" name="new_address" value="1">
                <div class="form-group">
                    <label>Full Name:</label>
                    <input type="text" class="form-control" name="fullname" required>
                </div>
                <div class="form-group">
                    <label>Address Line 1:</label>
                    <input type="text" class="form-control" name="address_line1" required>
                </div>
                <div class="form-group">
                    <label>Address Line 2:</label>
                    <input type="text" class="form-control" name="address_line2">
                </div>
                <div class="form-group">
                    <label>City:</label>
                    <input type="text" class="form-control" name="city" required>
                </div>
                <div class="form-group">
                    <label>State:</label>
                    <input type="text" class="form-control" name="state" required>
                </div>
                <div class="form-group">
                    <label>Zip Code:</label>
                    <input type="text" class="form-control" name="zip_code" required>
                </div>
                <div class="form-group">
                    <label for="country">Country:</label>
                    <select class="form-control" id="country" name="country" required>
                        <option value="">Select a Country</option>
                        <option value="USA">United States</option>
                        <option value="CAN">Canada</option>
                        <!-- Add more countries as needed -->
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Save New Address</button>
            </form>
        </div>
        <div class="col-md-6">
            <h2 id="addressNotify">Select Address before Payment</h2>
            <div id="addressDisplay" class="address-display" style="margin-bottom: 20pt"></div>
            <h5 id="totalPrice" style="margin-bottom: 20pt;visibility: hidden">Total: $<?= $total_amount ?></h5>
            <div id="paypal-button-container"></div>
        </div>
    </div>
</div>
<script src="/js/checkout.js"></script>
</body>
</html>

