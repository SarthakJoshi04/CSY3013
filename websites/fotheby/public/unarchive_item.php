<?php
// Start the session to access session variables
session_start();

// Include the database connection file
require('./dbconnection.php');

// Check if the user is logged in and is the admin
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    // Redirect to admin login page if not logged in as admin
    header('Location: admin_login.php');
    exit;
}

// Check if the item ID is provided via GET request
if (isset($_GET['id'])) {
    $itemId = $_GET['id'];

    // Prepare the SQL statement to update the 'isArchived' field to 0 (unarchive)
    $stmt = $Connection->prepare("UPDATE items SET isArchived = 0 WHERE id = :id");
    $stmt->bindParam(':id', $itemId, PDO::PARAM_INT); // Bind the item ID to the SQL query

    // Execute the SQL statement
    if ($stmt->execute()) {
        // If successful, alert the admin and redirect to the archive section of the admin panel
        echo "<script>alert('Item unarchived!'); window.location.href='admin_panel.php?a=archive';</script>";
        exit;
    } else {
        // Display an error message if the update fails
        die('Error unarchiving item.');
    }
} else {
    // Display an error if the item ID is not provided
    die('Item ID not provided.');
}