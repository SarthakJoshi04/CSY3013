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

// Array containing categories for the items
$categories = ['drawings', 'paintings', 'photographs', 'sculptures', 'carvings'];

// Initialize variables to hold item details
$itemId = null;
$item = null;

// Check if itemId is passed via GET or POST method
if (isset($_GET['id']) && isset($_GET['category'])) {
    $itemId = $_GET['id']; // Use GET method to fetch the item ID
} elseif (isset($_POST['item_id'])) {
    $itemId = $_POST['item_id']; // Use POST method to fetch the item ID
}

// Fetch item details if itemId is provided
if ($itemId !== null) {
    // Prepare a query to fetch item details from the database using item ID
    $stmt = $Connection->prepare("SELECT * FROM items WHERE id = :id");
    $stmt->bindParam(':id', $itemId, PDO::PARAM_INT);
    $stmt->execute();
    $item = $stmt->fetch(PDO::FETCH_ASSOC); // Store the item details
}

// Check if the form is submitted (POST request) and an item exists
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $item !== null) {
    // Fetch the form input values
    $lot_number = $_POST['lot_number'];
    $creator = ucwords($_POST['creator']); // Capitalize the first letter of each word
    $category = ucfirst($_POST['category']); // Capitalize the first letter of the category
    $date_of_creation = $_POST['date_of_creation'];
    $description = $_POST['item_description'];

    // Prepare the update query to update item details in the database
    $update = $Connection->prepare("UPDATE items SET
        lot_number = :lot_number,
        creator = :creator,
        category = :category,
        date_of_creation = :date_of_creation,
        description = :description
        WHERE id = :id");

    // Bind the input values to the query
    $update->bindParam(':lot_number', $lot_number);
    $update->bindParam(':creator', $creator);
    $update->bindParam(':category', $category);
    $update->bindParam(':date_of_creation', $date_of_creation);
    $update->bindParam(':description', $description);
    $update->bindParam(':id', $itemId, PDO::PARAM_INT);

    // Execute the update query
    $update->execute();

    // Check if the update was successful
    if ($update->rowCount() > 0) {
        // If successful, show success message and redirect to the admin panel
        echo "<script>alert('Item updated successfully!'); window.location.href='admin_panel.php?a=$category';</script>";
        exit;
    } else {
        // If no rows were updated or failed, show an error message
        echo "<script>alert('No changes were made or update failed.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item</title>
    <style>
        /* Reset all default margins and paddings for a clean slate */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Basic body styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        /* Main container styling */
        main {
            padding: 20px;
            margin: 120px auto;
        }

        /* Form container styling */
        .edit-item-form {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 80px);
            padding: 20px;
            margin: 20px;
        }

        /* Form title styling */
        .edit-item-form h1 {
            margin-bottom: 20px;
            font-size: 2em;
            text-align: center;
            color: #333;
        }

        /* Form layout and styling */
        .edit-item-form form {
            min-width: 300px;
            max-width: 500px;
            width: 100%;
            padding: 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Form label styling */
        .edit-item-form label {
            display: block;
            margin: 15px 0 5px;
            font-weight: bold;
        }

        /* Form inputs and textareas styling */
        .edit-item-form input[type="text"],
        .edit-item-form input[type="date"],
        .edit-item-form select,
        .edit-item-form textarea,
        .edit-item-form input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 1em;
        }

        /* Textarea resize option */
        .edit-item-form textarea {
            resize: vertical;
        }

        /* File input styling */
        .edit-item-form input[type="file"] {
            padding: 10px;
            background-color: #f9f9f9;
        }

        /* Submit button styling */
        .edit-item-form button {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            background-color: #007BFF;
            font-size: 1.1em;
            font-weight: 600;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Submit button hover effect */
        .edit-item-form button:hover {
            background-color: #0056b3;
        }

        /* Cancel button styling */
        .cancel-button {
            display: inline-block;
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            background-color: none;
            font-size: 1.1em;
            font-weight: 600;
            color: #d32f2f;
            text-align: center;
            text-decoration: none;
            border: 1px solid #d32f2f;
            border-radius: 5px;
            cursor: pointer;
            box-sizing: border-box;
        }

        /* Cancel button hover effect */
        .cancel-button:hover {
            background-color: #d32f2f;
            color: white;
        }
    </style>
</head>
<body>
    <main>
        <!-- Form to edit item details -->
        <div class="edit-item-form">
            <form action="edit_item.php" method="POST" enctype="multipart/form-data">
                <h1>Edit Item</h1>
                <!-- Hidden field for item id -->
                <input type="hidden" name="item_id" value="<?= $item['id'] ?>">

                <!-- Input field for lot number -->
                <label for="lot_number">Lot Number</label>
                <input type="text" id="lot_number" name="lot_number" value="<?= $item['lot_number'] ?>" required>

                <!-- Input field for creator -->
                <label for="creator">Creator</label>
                <input type="text" id="creator" name="creator" value="<?= $item['creator'] ?>" required>

                <!-- Select field for item category -->
                <label for="category">Category</label>
                <select id="category" name="category" required>
                    <option value="" disabled <?= empty($item['category']) ? 'selected' : '' ?>>Select</option>
                    <!-- Loop through categories and create options dynamically -->
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat ?>" <?= ($item['category'] ?? '') === $cat ? 'selected' : '' ?>>
                            <?= ucfirst($cat) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Input field for date of creation -->
                <label for="date_of_creation">Date of Creation</label>
                <input type="date" id="date_of_creation" name="date_of_creation" value="<?= $item['date_of_creation'] ?>" required>

                <!-- Input field for estimated price -->
                <label for="estimated_price">Estimated Price(£)</label>
                <input type="text" id="estimated_price" name="estimated_price" value="<?= $item['estimated_price'] ?>" required>

                <!-- Input field for auction date -->
                <label for="auction_date">Auction Date</label>
                <input type="date" id="auction_date" name="auction_date" value="<?= $item['auction_date'] ?>" required>

                <!-- Textarea for item description -->
                <label for="item_description">Description</label>
                <textarea id="item_description" name="item_description" rows="5" required><?= $item['description'] ?></textarea>

                <!-- Submit button to update the item -->
                <button type="submit">Update</button>

                <!-- Cancel button to go back to the admin panel -->
                <a class="cancel-button" href="admin_panel.php?a=<?= $item['category'] ?>">Cancel</a>
            </form>
        </div>
    </main>
</body>
</html>