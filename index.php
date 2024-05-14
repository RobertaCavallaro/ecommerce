<?php
include 'php/table_initialize.php';

session_start();  // Start the session first

// Check if the cookie with the correct name exists
if (isset($_COOKIE['user_id'])) {
    session_id($_COOKIE['user_id']);  // Set the session ID from the cookie
    $_SESSION['user_id'] = $_COOKIE['user_id'];  // Set the session variable
} else {
    setcookie("user_id", session_id(), time() + (86400 * 30), "/");  // Set the cookie
    $_SESSION['user_id'] = session_id();  // Manually set the session variable since cookie won't be available yet
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
  <link rel="stylesheet" href="css/style.css"> <!-- Link to your custom CSS file -->
    <link rel="icon" href="/images/trekking_tale.webp" type="image/x-icon">
  <script src="/js/index.js"></script>



</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light">
      <div class="container">
          <a href="#">
              <img src="/images/trekking_tale.webp" alt="TrekkingTale Logo" style="height: 50px; margin-right: 10px">
          </a>
          <a class="navbar-brand" href="#">TrekkingTale</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                  aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                  <li class="nav-item">
                      <a class="nav-link" href="#products">Shop All Gear</a>
                  </li>
                  <!-- Seasons Dropdown Menu -->
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Shop By Seasons
                      </a>
                      <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                          <a class="dropdown-item" data-season="summer" >Summer</a>
                          <a class="dropdown-item" data-season="autumn" >Autumn</a>
                          <a class="dropdown-item" data-season="winter" >Winter</a>
                          <a class="dropdown-item" data-season="spring" >Spring</a>
                      </div>
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
                      <a class="nav-link cart-button-index" href="php/view_cart.php"><i class="fas fa-shopping-cart" style="font-size: x-large;">
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


  <!-- Hero Section -->
  <section class="jumbotron text-center"
    style="background-image: url('images/trek.jpg'); background-size: cover; background-position: center; height: 70vh; position: relative;">

    <div class="search-container" style="position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%);">
      <form class="form-inline">
        <input id="custom-search-bar" class="form-control mr-sm-2" type="search" placeholder="Search"
          aria-label="Search">
        <button class="btn btn-warning my-2 my-sm-0" id="searchButton" type="submit" style="display: none">Search</button>
      </form>
    </div>
  </section>
  <div class="discount-bar bg-warning text-center py-2" style="margin-top: -32px;">
    <p class="mb-0">Get 20% discount on orders over $40!</p>
  </div>

  <!-- Login Modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="loginModalLabel">Login</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Iframe to load login.php -->
          <iframe src="php/login.php" frameborder="0" style="width:100%; height:400px;"></iframe>
        </div>
      </div>
    </div>
  </div>

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



  <section class="container" style="margin-top: 3rem; display: flex; flex-wrap: wrap;">
    <!-- Sidebar Section -->
    <aside class="sidebar col-md-3 mb-4">
      <div class="hawk-facet-rail search-facets-container desktop-facet-sidebar">
        <h4>Filter Options</h4>
        <!-- Gender -->
        <div class="form-group">
          <label for="gender">Gender:</label><br>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="male">
            <label class="form-check-label" for="male">Male</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="female">
            <label class="form-check-label" for="female">Female</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="unisex">
            <label class="form-check-label" for="unisex">Unisex</label>
          </div>
        </div>
        <!-- Season -->
        <div class="form-group">
          <label for="season">Season:</label><br>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="summer">
            <label class="form-check-label" for="summer">Summer</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="spring">
            <label class="form-check-label" for="spring">Spring</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="autumn">
            <label class="form-check-label" for="autumn">Autumn</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="winter">
            <label class="form-check-label" for="winter">Winter</label>
          </div>
        </div>
        Copied!
        <!-- Price Range -->
        <div class="form-group">
          <label for="price-range">Price Range:</label><br>
          <input type="range" class="form-control-range" id="price-range" min="40" max="400" value="150">
          <span>$10</span>
          <span style="float: right;">$400</span>
          <!-- Price Display -->
          <span id="price-display" style="padding-left: 30%">$150</span>
          <!-- Added element to display the slider value -->
        </div>
        <button class="btn btn-primary" id="apply-filters">Apply Filters</button>
      </div>
    </aside>

    <!-- Products Section -->
    <div id="products" class="col-md-9">
      <?php
      $conn = new mysqli($servername, $username, $password, $dbname, $port);
      $query = "SELECT * FROM products";
      $result = $conn->query($query);

      if ($result->num_rows > 0) {
        $counter = 0; // Initialize a counter
        echo '<div class="row product-row">'; // Start the first row

        while ($row = $result->fetch_assoc()) {
          if ($counter % 3 == 0 && $counter != 0) {
            echo '</div><div class="row product-row">'; // Close the current row and start a new one every 3 products
          }

          echo '<div class="col-md-4 mb-4 product-column">'; // Each product occupies one third of the row
          echo '<div class="card product-card" data-name="'
            . $row['name'] . '" data-description="' . $row['description'] .
            '" data-season="' . $row['season'] . '" data-gender="' . $row['gender'] . '"
                      data-price="' . $row['price'] . '" data-product-id="' . $row['product_id'] . '">';
          echo '<img src="' . $row['image_url'] . '" class="card-img-top" alt="' . $row['name'] . '">';
          echo '<div class="card-body">';
          echo '<h5 class="card-title">' . $row['name'] . '</h5>';
          echo '<p class="card-text">Price: $' . $row['price'] . '</p>';
          echo '<p class="card-text">Quantity:';
          echo '<div class="quantity-input d-flex">';
          echo '<button class="btn btn-sm btn-secondary quantity-btn minus-btn" type="button">-</button>';
          echo '<input type="text" class="form-control quantity" value="1">';
          echo '<button class="btn btn-sm btn-secondary quantity-btn plus-btn" type="button">+</button>';
          echo '</div>';
          echo '</p>';
          echo '<a href="#" class="btn btn-primary add-to-cart-btn">Add to Cart</a>';
          echo '</div>'; // Close card-body
          echo '</div>'; // Close card
          echo '</div>'; // Close col-md-4

          $counter++; // Increment the counter
        }

        echo '</div>'; // Close the last row
      } else {
        echo "No products found!";
      }
      ?>
    </div>
  </section>
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
</body>

</html>