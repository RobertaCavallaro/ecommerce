<?php
session_start(); // Start the session at the beginning of the script

// Include the database connection
include 'connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $conn = new mysqli($servername, $username, $password, $dbname, $port);
  // Get username and password from POST data
  $email = $conn->real_escape_string($_POST['email']);
  $pass = $conn->real_escape_string($_POST['password']);
  // Prepare SQL to prevent SQL injection
  $sql = "SELECT * FROM customers WHERE email='$email'";
  // Execute the query
  $result = $conn->query($sql);
  // Check if the user exists
  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    // Validate the password
    if (password_verify($pass, $user['password'])) {
      // Set session variables
      $_SESSION['loggedin'] = true;
      $_SESSION['email'] = $email;
      $_SESSION['user_id'] = $user['customer_id'];
      $_SESSION['user_name'] = $user['first_name']; // Assuming the first name is stored in 'first_name'

      // Redirect to home page
      echo "<script type='text/javascript'>window.top.location.href = '../index.php';</script>";
      exit;
    } else {
      echo "<p>Invalid username or password.</p>";
    }
  } else {
    echo "<p>No user found with that username.</p>";
  }
  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      padding-top: 40px;
      padding-bottom: 40px;
      background-color: #f5f5f5;
    }

    .form-signin {
      max-width: 330px;
      padding: 15px;
      margin: auto;
    }

    .form-signin .form-control {
      position: relative;
      height: auto;
      padding: 10px;
      box-sizing: border-box;
    }

    .form-signin .form-control:focus {
      z-index: 2;
    }

    .form-signin input[type="email"] {
      margin-bottom: -1px;
      border-bottom-right-radius: 0;
      border-bottom-left-radius: 0;
    }

    .form-signin input[type="password"] {
      margin-bottom: 10px;
      border-top-left-radius: 0;
      border-top-right-radius: 0;
    }

    .signup-link {
      text-align: center;
      margin-top: 10px;
    }
  </style>
</head>

<body>
  <div class="container">
    <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <h2 class="form-signin-heading">Please sign in</h2>
      <label for="email" class="sr-only">Email address</label>
      <input type="email" id="email" name="email" class="form-control" placeholder="Email address" required autofocus>
      <label for="password" class="sr-only">Password</label>
      <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      <p class="signup-link">Don't have an account? <a href="signup.php">Sign up now</a></p>
    </form>
  </div>
</body>

</html>