<?php
// Include necessary files and perform any required logic
include 'php/connect.php'; // Assuming this file contains your database connection logic

// Example of processing form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form data
    // Example: Insert data into the database, calculate total cost, etc.
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout - TrekkingTale</title>
</head>
<body>
  <h2>Checkout</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <!-- Your checkout form fields here -->
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br><br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>
    <label for="address">Address:</label>
    <textarea id="address" name="address" rows="4" cols="50" required></textarea><br><br>
    <input type="submit" value="Submit">
  </form>
</body>
</html>
