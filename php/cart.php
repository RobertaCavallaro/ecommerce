<?php
include 'php/connect.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shopping Cart - TrekkingTale</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="css/style.css"> <!-- Link to your custom CSS file -->
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light">
    <!-- Navbar content -->
  </nav>

  <!-- Cart Items -->
  <section class="container">
    <h2 class="mt-5 mb-4">Shopping Cart</h2>
    <div class="row">
      <div class="col-md-8">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Product</th>
              <th scope="col">Price</th>
              <th scope="col">Quantity</th>
              <th scope="col">Total</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <!-- Display cart items dynamically here using PHP -->
            <!-- Example: -->
            <!-- <tr>
              <th scope="row">1</th>
              <td>Product Name</td>
              <td>$100</td>
              <td>2</td>
              <td>$200</td>
              <td><button class="btn btn-danger">Remove</button></td>
            </tr> -->
          </tbody>
        </table>
      </div>
      <div class="col-md-4">
        <!-- Cart Summary -->
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Cart Summary</h5>
            <p class="card-text">Total Items: <span id="totalItems">0</span></p>
            <p class="card-text">Total Price: <span id="totalPrice">$0</span></p>
            <a href="php/checkout.php" class="btn btn-primary">Proceed to Checkout</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Bootstrap JS and jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
