<?php
session_start(); // Start the session
include 'connect.php'; // Database connection

$signupSuccess = false; // Default to false

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $conn = new mysqli($servername, $username, $password, $dbname, $port);
  $firstname = $conn->real_escape_string($_POST['firstname']);
  $lastname = $conn->real_escape_string($_POST['lastname']);
  $email = $conn->real_escape_string($_POST['email']);
  $password = $conn->real_escape_string($_POST['password']);

  // Password hashing
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  // Prepare an insert statement
  $sql = "INSERT INTO customers (customer_id, first_name, last_name, email, password) VALUES (? ,?, ?, ?, ?)";

  if ($stmt = $conn->prepare($sql)) {
    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("sssss", $_COOKIE['userd_id'], $firstname, $lastname, $email, $hashed_password);

    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
      // Redirect with success query parameter
      header("Location: signup.php?success=true");
      exit(); // Ensure no further processing is done after redirection
    } else {
      echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
  } else {
    echo "Error preparing statement: " . $conn->error;
  }

  // Close connection
  $conn->close();
} else {
  // Check for success query parameter to determine if signup was successful
  $signupSuccess = isset($_GET['success']) && $_GET['success'] == 'true';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      padding-top: 40px;
      padding-bottom: 40px;
      background-color: #f5f5f5;
    }

    .form-signup {
      max-width: 330px;
      padding: 15px;
      margin: auto;
    }

    .form-signup .form-control {
      position: relative;
      height: auto;
      padding: 10px;
      box-sizing: border-box;
    }

    .form-signup input[type="email"],
    .form-signup input[type="text"],
    .form-signup input[type="password"] {
      margin-bottom: 10px;
    }

    .btn-primary {
      background-color: rgb(208, 237, 211) !important;
      color: black;
      border-color: yellow !important;
    }

    .login-link {
      text-align: center;
      /* Centers the login link */
      margin-top: 10px;
      /* Adds a little space above the link */
    }
  </style>
</head>

<body>
  <div class="container">
    <?php if (!$signupSuccess): ?>
      <form class="form-signup" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h2 class="form-signup-heading">Please sign up</h2>
        <input type="text" id="inputFirstName" name="firstname" class="form-control" placeholder="First name" required
          autofocus>
        <input type="text" id="inputLastName" name="lastname" class="form-control" placeholder="Last name" required>
        <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required>
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
        <p class="login-link">Already have an account? <a href="login.php">Login here</a></p> <!-- Added login link -->
      </form>
    <?php else: ?>
      <p class="alert alert-success" role="alert">Signup successful! <a href="login.php">Login here</a></p>
    <?php endif; ?>
  </div>
</body>

</html>