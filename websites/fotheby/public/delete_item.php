<?php
// Starting the session to manage user login
session_start();

// Including the dbconnection.php file for database connection
require('dbconnection.php');

// Check if the user is logged in as 'admin', if not, redirect to admin login page
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    // Redirect to admin login page if the user is not an admin
    header('Location: admin_login.php');
    exit;
}

// Check if item ID and category are provided in the URL query string
if (isset($_GET['id']) && isset($_GET['category'])) {
    // Get item ID and category from URL
    $itemId = $_GET['id']; // Item ID to be deleted
    $itemCategory = strtolower($_GET['category']); // Item category for redirection

    try {
        // Prepare a query to delete the item itself
        $deleteItem = $Connection->prepare("DELETE FROM items WHERE id = :id");
        $deleteItem->bindParam(':id', $itemId, PDO::PARAM_INT); // Bind item ID parameter
        $deleteItem->execute(); // Execute the delete query for item

        // Show success message and redirect to admin panel with the correct category
        echo "<script>alert('Item deleted!'); 
            window.location.href='admin_panel.php?a=" . urlencode($itemCategory) . "'; 
        </script>";
        exit;
    } catch (PDOException $e) {
        // Display error message if something goes wrong during the delete operation
        die("Error deleting item: " . $e->getMessage());
    }
}
?>