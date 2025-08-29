<?php
// Start the session to manage user sessions
session_start();

// Include the database connection file
require ('./dbconnection.php');

// Initialize error message variable
$errorMessage = '';

// Check if the login form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Sanitize and retrieve user inputs
  $username = trim($_POST['username']);
  $password = $_POST['password'];

  // Server-side validation for empty fields
  if (empty($username) || empty($password)) {
    $errorMessage = "Please fill in all fields.";
  } else {
    try {
      // Prepare SQL statement to fetch user by username
      $stmt = $Connection->prepare("SELECT * FROM clients WHERE username = :username LIMIT 1");
      $stmt->bindParam(':username', $username);
      $stmt->execute();
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      // Verify user exists and password is correct
      if ($user && password_verify($password, $user['password'])) {
          // Successful login: set session variable and redirect to catalogue
          $_SESSION['username'] = $user['username'];
          header("Location: auction_catalogue.php");
          exit;
      } else {
        // Invalid credentials
        $errorMessage = "Invalid username or password.";
      }
    } catch (PDOException $e) {
      // Database connection or query error
      $errorMessage = "Database error: " . $e->getMessage();
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
  <style>
    /* Basic styling for layout and form elements */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        color: #333;
    }
    div {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }
    div p {
        font-size: 0.8em;
    }
    div a {
        color: #007BFF;
        text-decoration: none;
    }
    div a:hover {
        text-decoration: underline;
    }
    h1 {
        text-align: center;
    }
    form {
        min-width: 300px;
        margin: 30px auto;
        padding: 20px;
        background-color: white;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    label {
        display: block;
        margin-bottom: 10px;
    }
    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    button {
        width: 100%;
        padding: 10px;
        background-color: #007BFF;
        font-size: 1.1em;
        font-weight: 600;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    button:hover {
        background-color: #0056b3;
    }
    button:disabled {
        background-color: #ccc;
        cursor: not-allowed;
    }
  </style>
</head>
<body>

  <!-- Include header -->
  <?php include('./header.php') ?>

  <div>
    <h1>Client Login</h1>
    
    <!-- Login Form -->
    <form action="login.php" method="post">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" required>
      <br>
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>
      <br>
      <button type="submit" id="loginBtn" disabled>Login</button>
    </form>

    <!-- Registration link -->
    <p>Don't have an account? <a href="register.php">Register here</a></p>

    <!-- Display error message if any -->
    <?php if ($errorMessage): ?>
      <p style="color: red;"><?php echo $errorMessage; ?></p>
    <?php endif; ?>
  </div>

  <!-- Include footer -->
  <?php include('./footer.php') ?>

  <script>
    // Client-side validation to enable/disable login button
    const username = document.getElementById('username');
    const password = document.getElementById('password');
    const loginBtn = document.getElementById('loginBtn');

    function validateLoginForm() {
        loginBtn.disabled = !username.value || !password.value;
    }

    // Add event listeners to input fields
    username.addEventListener('input', validateLoginForm);
    password.addEventListener('input', validateLoginForm);
  </script>
</body>
</html>
