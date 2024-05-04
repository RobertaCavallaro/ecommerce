<?php
include 'php/connect.php';
session_start();
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
  <link rel="stylesheet" href="path/to/cody-style-guide.css">
  <script src="/js/cart.js"></script>



</head>

<body>


  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
      <a class="navbar-brand" href="#">TrekkingTale</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="#products">Shop Gear</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#planYourTrek">Plan your trek</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="modal" data-target="#aboutModal">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="modal" data-target="#contactModal">Contact</a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto"> <!-- Adjusted to ml-auto for alignment to the right -->
          <li class="nav-item">
            <a class="nav-link" href="#"><i class="fas fa-shopping-cart" style="font-size: x-large;"> <span
                  id="cartItemCount">0</span></i></a>
          </li>
          <?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true): ?>
            <li class="nav-item">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginModal"> Login </button>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link" href="#">Hello, <?php echo htmlspecialchars($_SESSION['user_name']); ?></a>
              <!-- Display user's name -->
            </li>
            <li class="nav-item">
              <a class="nav-link" href="php/logout.php">Logout</a> <!-- Logout button -->
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
        <button class="btn btn-warning my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </section>
  <div class="discount-bar bg-warning text-center py-2" style="margin-top: -32px;">
    <p class="mb-0">Get 20% discount on orders over $40!</p>
  </div>
  <!-- Season Images Section -->
  <div id="planYourTrek" class="foto row">
    <div class="col-md-3">
      <img src="images/spring.jpg" alt="Spring" class="img-fluid">
      <a href="spring.html" class="season-link">
        <p class="season-text">Spring</p>
      </a>
    </div>
    <div class="col-md-3">
      <img src="images/summer.jpg" alt="Summer" class="img-fluid">
      <a href="summer.html" class="season-link">
        <p class="season-text">Summer</p>
      </a>
    </div>
    <div class="col-md-3">
      <img src="images/fall.jpg" alt="Autumn" class="img-fluid">
      <a href="autumn.html" class="season-link">
        <p class="season-text">Autumn</p>
      </a>
    </div>
    <div class="col-md-3">
      <img src="images/winter.jpg" alt="Winter" class="img-fluid">
      <a href="winter.html" class="season-link">
        <p class="season-text">Winter</p>
      </a>
    </div>
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
          <h5 class="modal-title" id="aboutModalLabel">About Us</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h2>About Our Company</h2>
          <p>This is the About page content. Our company has been leading the industry for over 20 years, providing
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
        <!-- Color -->
        <div class="form-group">
          <label for="color">Color:</label><br>
          <div class="color-options">
            <span class="color-option" style="background-color: black;"></span>
            <span class="color-option" style="background-color: blue;"></span>
            <span class="color-option" style="background-color: green;"></span>
            <span class="color-option" style="background-color: red;"></span>
            <span class="color-option" style="background-color: yellow;"></span>
            <span class="color-option" style="background-color: orange;"></span>
          </div>
          <div class="color-options">
            <span class="color-option" style="background-color: pink;"></span>
            <span class="color-option" style="background-color: purple;"></span>
            <span class="color-option" style="background-color: brown;"></span>
            <span class="color-option" style="background-color: cyan;"></span>
            <span class="color-option" style="background-color: magenta;"></span>
            <span class="color-option" style="background-color: silver;"></span>
          </div>
        </div>

        <!-- Price Range -->
        <div class="form-group">
          <label for="price-range">Price Range:</label><br>
          <input type="range" class="form-control-range" id="price-range" min="10" max="400" value="10">
          <span>$10</span>
          <span style="float: right;">$400</span>
        </div>
        <button class="btn btn-primary">Apply Filters</button>
      </div>
    </aside>

    <!-- Products Section -->
    <div id="products" class="col-md-9">
      <!-- Row for Product 1 and Product 2 -->
      <div class="row">
        <!-- Column for Product 1 -->
        <div class="col-md-4 mb-4">
          <div class="card">
            <img src="images/tent.jpg" class="card-img-top" alt="Camping Tent">
            <div class="card-body">
              <h5 class="card-title">Camping Tent</h5>
              <p class="card-text">Price: $150</p>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star"></span>
              (74)

              <p class="card-text">Quantity:
              <div class="quantity-input d-flex">
                <button class="btn btn-sm btn-secondary quantity-btn minus-btn" type="button">-</button>
                <input type="text" class="form-control quantity" value="1">
                <button class="btn btn-sm btn-secondary quantity-btn plus-btn" type="button">+</button>
              </div>
              </p>
              <a href="#" class="btn btn-primary">Add to Cart</a>
            </div>
          </div>
        </div>
        <!-- Column for Product 2 -->
        <div class="col-md-4 mb-4">
          <div class="card">
            <img src="images/backpag.jpg" class="card-img-top" alt="backpack">
            <div class="card-body">
              <h5 class="card-title">Backpack</h5>
              <p class="card-text">Price: $50</p>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star"></span>
              (74)

              <p class="card-text">Quantity:
              <div class="quantity-input d-flex">
                <button class="btn btn-sm btn-secondary quantity-btn minus-btn" type="button">-</button>
                <input type="text" class="form-control quantity" value="1">
                <button class="btn btn-sm btn-secondary quantity-btn plus-btn" type="button">+</button>
              </div>
              </p>
              <a href="#" class="btn btn-primary">Add to Cart</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Row for Product 3 and Product 4 -->
      <div class="row">
        <!-- Column for Product 3 -->
        <div class="col-md-4 mb-4">
          <div class="card">
            <img src="images/luce.jpg" class="card-img-top" alt="headlamp">
            <div class="card-body">
              <h5 class="card-title">Headlamp</h5>
              <p class="card-text">Price: $40</p>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star"></span>
              (74)

              <p class="card-text">Quantity:
              <div class="quantity-input d-flex">
                <button class="btn btn-sm btn-secondary quantity-btn minus-btn" type="button">-</button>
                <input type="text" class="form-control quantity" value="1">
                <button class="btn btn-sm btn-secondary quantity-btn plus-btn" type="button">+</button>
              </div>
              </p>
              <a href="#" class="btn btn-primary">Add to Cart</a>
            </div>
          </div>
        </div>
        <!-- Column for Product 4 -->
        <div class="col-md-4 mb-4">
          <div class="card">
            <img src="images/trekking.PNG" class="card-img-top" alt="poles">
            <div class="card-body">
              <h5 class="card-title">Trail Trekking Poles</h5>
              <p class="card-text">Price: $60</p>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star"></span>
              (74)

              <p class="card-text">Quantity:
              <div class="quantity-input d-flex">
                <button class="btn btn-sm btn-secondary quantity-btn minus-btn" type="button">-</button>
                <input type="text" class="form-control quantity" value="1">
                <button class="btn btn-sm btn-secondary quantity-btn plus-btn" type="button">+</button>
              </div>
              </p>
              <a href="#" class="btn btn-primary">Add to Cart</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Load More Button -->
  <div class="button-container">
    <button class="btn btn-primary load-more">Load More</button>
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
</body>

</html>