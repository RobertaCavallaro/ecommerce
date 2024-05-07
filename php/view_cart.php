<?php
session_start();
include 'connect.php'; // Assumes you have a connect.php file to handle database connection

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$conn = new mysqli($servername, $username, $password, $dbname, $port);

$query = "SELECT cart.product_id, products.name, products.description, products.price, cart.quantity, products.image_url FROM cart INNER JOIN products ON cart.product_id = products.product_id WHERE cart.customer_id  = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

$totalPrice = 0;
while ($row = $result->fetch_assoc()) {
    $totalPrice += $row['quantity'] * $row['price'];
}
$result->data_seek(0);
$conn -> close();
//?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/css/style.css"> <!-- Link to your custom CSS file -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/js/cart.js"></script>

</head>

<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="../index.php">TrekkingTale</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Shop Gear</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto"> <!-- Adjusted to ml-auto for alignment to the right -->
                <?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true): ?>
                    <li class="nav-item">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="index.php"> Login </button>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Hello, <?php echo htmlspecialchars($_SESSION['user_name']); ?></a>
                        <!-- Display user's name -->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a> <!-- Logout button -->
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<!-- Checkout Modal -->
<div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkoutModalLabel">Checkout</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Iframe to load login.php -->
                <iframe src="checkout.php" frameborder="0" style="width:100%; height:400px;"></iframe>
            </div>
        </div>
    </div>
</div>

<div class="cart-container">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="cart-item">
            <img src="/<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
            <div class="details">
                <h3><?= htmlspecialchars($row['name']) ?></h3>
                <p><?= htmlspecialchars($row['description']) ?></p>
                <p>Price: $<?= number_format($row['price'], 2) ?></p>
                <!-- Quantity controls -->
                <div class="quantity-controls">
                    <button class="minus-btn" data-id="<?= $row['product_id'] ?>">-</button>
                    <input type="text" class="quantity" value="<?= htmlspecialchars($row['quantity']) ?>">
                    <button class="plus-btn" data-id="<?= $row['product_id'] ?>">+</button>
                </div>
                <p>Subtotal: $<?= number_format($row['quantity'] * $row['price'], 2) ?></p>
                <!-- Delete item button -->
                <button class="delete-btn" data-id="<?= $row['product_id'] ?>">Delete Item</button>
            </div>
        </div>

    <?php endwhile; ?>

    <div class="total-and-checkout">
        <button data-toggle="modal" data-target="#checkoutModal"
                class="btn btn-success">Order Now</button>
        <span class="total-price">Total: $<?= number_format($totalPrice, 2) ?></span>
    </div>

    <script>
        var isLoggedIn = <?php echo isset($_SESSION['loggedin']) && $_SESSION['loggedin'] ? 'true' : 'false'; ?>;
    </script>

</body>
</html>
<?php //$stmt->close(); ?>
