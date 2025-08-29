<?php
// Include the database connection file
require ('./dbconnection.php');

// Initialize feedback messages
$successMessage = '';
$errorMessage = '';

// Check if the form is submitted using POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and trim form inputs
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Basic server-side validation
    if (empty($username) || empty($password) || $password !== $confirm_password) {
        die("Validation error. Please ensure all fields are filled and passwords match.");
    }

    // Securely hash the password before storing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Prepare SQL query to insert new user
        $stmt = $Connection->prepare("INSERT INTO clients (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashed_password);

        // Execute the SQL statement
        $stmt->execute();

        // Redirect using PRG pattern to avoid form resubmission
        header("Location: register.php?success=1");
        exit;
    } catch (PDOException $e) {
        // Handle duplicate username error (SQLSTATE 23000 = integrity constraint violation)
        if ($e->getCode() == 23000) {
           $errorMessage = "Username Registered Before";
        } else {
            $errorMessage = "Error: " . $e->getMessage();
        }
    }
}

// Display success message after PRG redirect
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $successMessage = "Registered Successfully. Proceed to Login.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <style>
        /* Basic CSS reset and styling */
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
            height: 100%;
        }
        div h1 {
            font-size: 2em;
            margin-top: 20px;
        }
        p {
            font-size: 0.8em;
        }
        a {
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
            min-width: 500px;
            max-width: 600px;
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
    <?php include('./header.php') ?>
    <div>
        <h1>Register into Fotheby's Auction House</h1>
        <!-- Registration form -->
        <form action="register.php" method="post">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            <br>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <br>
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <br>
            <!-- Register button is disabled by default -->
            <button type="submit" id="registerBtn" disabled>Register</button>
        </form>

        <!-- Login link for existing users -->
        <p>Already a registered member? <a href="login.php">Login here</a>.</p>

        <!-- Display feedback messages -->
        <?php if ($successMessage): ?>
            <div style="color: green; margin: 10px 0;"><?= $successMessage ?></div>
        <?php elseif ($errorMessage): ?>
            <div style="color: red; margin: 10px 0;"><?= $errorMessage ?></div>
        <?php endif; ?>
    </div>

    <?php include('./footer.php') ?>

    <!-- Client-side validation for enabling/disabling register button -->
    <script>
        const username = document.getElementById('username');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm_password');
        const registerBtn = document.getElementById('registerBtn');

        // Enable register button only if all fields are valid and passwords match
        function validateResgisterForm() {
            registerBtn.disabled = password.value !== confirmPassword.value || !password.value || !username.value;
        }

        // Attach event listeners to input fields
        username.addEventListener('input', validateResgisterForm);
        password.addEventListener('input', validateResgisterForm);
        confirmPassword.addEventListener('input', validateResgisterForm);
    </script>
</body>
</html>