<?php
// Start the session to manage user sessions
session_start();

// Include the database connection file to interact with the database
require ('./dbconnection.php');

// Check if the user is logged in as admin by checking session variables
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    // Redirect to admin login page if the user is not logged in as admin
    header('Location: admin_login.php');
    exit;
}

// Check if 'id' and 'category' are provided in the URL parameters
if (isset($_GET['id']) && isset($_GET['category'])) {
    // Assign the item ID and category to variables
    $itemId = $_GET['id'];
    $itemCategory = strtolower($_GET['category']);
    
    // Prepare the SQL statement to update the 'isArchived' field to 1 (archived)
    $stmt = $Connection->prepare("UPDATE items SET isArchived = 1 WHERE id = :id");
    $stmt->bindParam(':id', $itemId, PDO::PARAM_INT); // Bind the ID parameter to the statement
    
    // Execute the SQL statement to archive the item
    if ($stmt->execute()) {
        // If the execution is successful, show an alert and redirect back to the admin panel
        echo "<script>alert('Item archived!');
            window.location.href='admin_panel.php?a=" . urlencode($itemCategory) . "'; 
        </script>";
        exit;
    } else {
        // If there was an error executing the query, display an error message
        die('Error archiving item.');
    }
} else {
    // If 'id' or 'category' is not provided in the URL, display an error message
    die('Item ID not provided.');
}