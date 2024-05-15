<?php
include 'table_initialize.php';
$conn = new mysqli($servername, $username, $password, $dbname, $port);
$query = "SELECT * FROM products";
$result = $conn->query($query);

if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];
    $stmt = $conn->prepare('SELECT * FROM products WHERE product_id = ?');
    $stmt->bind_param("i",$productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
//    echo json_encode($product);
} else {
//    echo json_encode(['message' => 'Product ID not provided']);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrekkingTale</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/product.css">
    <link rel="icon" href="/images/trekking_tale.webp" type="image/x-icon">
    <script src="/js/product.js"></script>



</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a href="../index.php">
            <img src="/images/trekking_tale.webp" alt="TrekkingTale Logo" style="height: 50px; margin-right: 10px">
        </a>
        <a class="navbar-brand" href="../index.php">TrekkingTale</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Shop All Gear</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#aboutModal">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#contactModal">Contact</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link cart-button-index" href="view_cart.php"><i class="fas fa-shopping-cart" style="font-size: x-large;">
                            <span id="cartItemCount">0</span></i></a>
                </li>
                <?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true): ?>
                    <li class="nav-item" style="display: none">
                        <a type="button" class="nav-link" data-toggle="modal" data-target="#loginModal"> Login </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Hello, <?php echo htmlspecialchars($_SESSION['user_name']); ?></a>
                        <!-- Display user's name -->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="php/logout.php">Logout</a>
                        <!-- Logout button -->
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!--    product details-->
<?php
if(isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $conn = new mysqli($servername, $username, $password, $dbname, $port);
    $query = "SELECT * FROM products WHERE product_id = $product_id";
    $result = $conn->query($query);

    if($row = $result->fetch_assoc()) {
        echo '<div class="product-details">';
        echo '<h1>' . $row['name'] . '</h1>';
        echo '<img src="../' . $row['image_url'] . '" alt="' . htmlspecialchars($row['name']) . '" title="' . htmlspecialchars($row['name']) . '">';
        echo '<p><b>' . $row['description'] . '</b></p>';
        echo '<p>' . $row['full_description'] . '</p>';
        echo '<p><b>Price:</b> $' . $row['price'] . '</p>';
        echo '<p><b>In Stock:</b> ' . $row['stock'] . '</p>';
        echo '<p><b>For Season:</b> ' . $row['season'] . '</p>';
        echo '<p><b>Gender:</b> ' . $row['gender'] . '</p>';
        echo '<p><b>Category:</b> ' . $row['category'] . '</p>';
        echo '<p><b>Weight:</b> ' . $row['weight'] . ' kg</p>';
        echo '<p><b>Dimensions:</b> ' . $row['dimensions'] . '</p>';
        echo '<p><b>Materials:</b> ' . $row['materials'] . '</p>';
        echo '<p><b>Color:</b> ' . $row['color'] . '</p>';
        // Quantity controls
        echo '<div class="quantity-controls">';
        echo '<button id="decreaseQuantity" class="quantity-btn">-</button>';
        echo '<input type="number" id="productQuantity" ' . 'data-product-id="' . $row['product_id']. '" value="1" min="1">';
        echo '<button id="increaseQuantity" class="quantity-btn">+</button>';
        echo '</div>';

        // Add to Cart button
        echo '<button id="addToCartBtn" class="btn">Add to Cart</button>';

        echo '</div>';
    } else {
        echo "Product not found.";
    }
} else {
    echo "Invalid product.";
}
?>


    <!-- About Modal -->
    <div class="modal fade" id="aboutModal" tabindex="-1" role="dialog" aria-labelledby="aboutModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="aboutModalLabel">About Our Company</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Our company has been leading the industry for over 20 years, providing
                        high-quality services to our customers. Learn more about our mission, vision, and the values that drive our
                        organization forward.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Modal -->
    <div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="contactModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactModalLabel">Contact Us</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type='text' class="form-control" placeholder='Your name'>
                        <input type='email' class="form-control" placeholder='Your email'>
                        <textarea class="form-control" rows="4" placeholder='Your message'></textarea>
                        <button type='submit' class="btn btn-primary">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- Footer -->
<footer class="footer mt-auto py-3">
    <div class="container">
        <div class="row">
            <!-- Contact Info -->
            <div class="col-md-4">
                <h5>Contact Info</h5>
                <p><strong>Phone:</strong> 618294052</p>
                <p><strong>Address:</strong> Lorem Ipsum</p>
                <p><strong>Hours:</strong> 8 am to 10 pm</p>
            </div>
            <!-- Sales & Discount Section -->
            <div class="col-md-4">
                <h5>Sales & Discount</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-decoration-none">Coupons</a></li>
                    <li><a href="#" class="text-decoration-none">Free Delivery</a></li>
                </ul>
            </div>
            <!-- Orders Section -->
            <div class="col-md-4">
                <h5>Orders</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-decoration-none">Order Status</a></li>
                    <li><a href="#" class="text-decoration-none">Returns</a></li>
                    <li><a href="#" class="text-decoration-none">eGift Cards</a></li>
                    <li><a href="#" class="text-decoration-none">Shipping</a></li>
                    <li><a href="#" class="text-decoration-none">Order FAQs</a></li>
                </ul>
            </div>
        </div>
        <hr>
        <!-- Sign Up for Email -->
        <div class="row">
            <div class="col-md-6">
                <h5>Sign Up for Email</h5>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Enter your email" aria-label="Email"
                           aria-describedby="button-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="button-addon2">Sign Up</button>
                    </div>
                </div>
            </div>
            <!-- Social Media Icons -->
            <div class="col-md-6">
                <h5>Follow Us</h5>
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                    <li class="list-inline-item"><a href="#"><i class="fab fa-twitter"></i></a></li>
                    <li class="list-inline-item"><a href="#"><i class="fab fa-instagram"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>


<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    var isLoggedIn = <?php echo isset($_SESSION['loggedin']) && $_SESSION['loggedin'] ? 'true' : 'false'; ?>;
</script>
<script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "Product",
      "name": "<?php echo htmlspecialchars($row['name']); ?>",
  "description": "<?php echo htmlspecialchars($row['description']); ?>",
  "image": "<?php echo $row['image_url']; ?>",
  "offers": {
    "@type": "Offer",
    "priceCurrency": "USD",
    "price": "<?php echo $row['price']; ?>"
  }
}
</script>
</body>

</html>