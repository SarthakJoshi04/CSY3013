<?php
// Start the session to manage user sessions
session_start();

// Initialize an error message variable
$errorMessage = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    
    // Server side form validation
    if (empty($password)) {
        die("Validation error. Please ensure all fields are filled.");
    }

    // Check if the password entered is correct
    if ($password === 'admin') {
        $_SESSION['username'] = 'admin'; // Store session data for admin
        // Redirect to admin panel
        header("Location: admin_panel.php");
        exit;
    } else {
        // If password is incorrect, show error message
        $errorMessage = "Invalid password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
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
            height: 100%;
        }
        div h1 {
            text-align: center;
            margin: 20px 0;
        }
        form {
            min-width: 300px;
            padding: 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
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
    <?php include('./header.php') ?> <!-- Include header file -->
    <div>  
        <h1>Admin Login</h1>
        <!-- Login form for password entry -->
        <form action="admin_login.php" method="POST">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <br>
            <!-- Login button, initially disabled until a password is entered -->
            <button type="submit" id="loginBtn" disabled>Login</button>
        </form>
        <?php if ($errorMessage): ?>
            <!-- Display error message if password is incorrect -->
            <div style="color: red; margin: 10px 0;"><?= $errorMessage ?></div>
        <?php endif; ?>
    </div>

    <?php include('./footer.php') ?> <!-- Include footer file -->

    <script>
        const password = document.getElementById('password');
        const loginBtn = document.getElementById('loginBtn');

        // Function to enable/disable the login button based on password input
        function validateLoginForm() {
            loginBtn.disabled = !password.value; // Enable button only if password is not empty
        }

        password.addEventListener('input', validateLoginForm); // Add event listener to password field
    </script>
</body>
</html>