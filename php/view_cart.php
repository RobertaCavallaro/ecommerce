<?php
// Include necessary files and perform any required logic
include 'php/connect.php'; // Assuming this file contains your database connection logic

// Example of retrieving cart items from session or database
$cartItems = []; // This should be replaced with actual logic to retrieve cart items

// Example of processing form submission (updating cart, removing items, etc.)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form data
    // Example: Update cart quantities, remove items from cart, etc.
}

// Example of calculating total cost
$totalCost = 0; // Initialize total cost variable

foreach ($cartItems as $item) {
    // Calculate total cost based on item prices and quantities
    $totalCost += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Cart - TrekkingTale</title>
  <!-- Include necessary stylesheets and scripts -->
</head>
<body>
  <h2>View Cart</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <!-- Display cart items -->
    <?php if (!empty($cartItems)) : ?>
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item) : ?>
                    <tr>
                        <td><?php echo $item['name']; ?></td>
                        <td>$<?php echo $item['price']; ?></td>
                        <td>
                            <input type="number" name="quantity[<?php echo $item['id']; ?>]" value="<?php echo $item['quantity']; ?>">
                        </td>
                        <td>$<?php echo $item['price'] * $item['quantity']; ?></td>
                        <td>
                            <button type="submit" name="update" value="<?php echo $item['id']; ?>">Update</button>
                            <button type="submit" name="remove" value="<?php echo $item['id']; ?>">Remove</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td colspan="2">$<?php echo $totalCost; ?></td>
                </tr>
            </tbody>
        </table>
        <button type="submit" name="checkout">Checkout</button>
    <?php else : ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
  </form>
</body>
</html>
