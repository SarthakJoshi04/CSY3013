<?php
// Include the database connection file
require('./dbconnection.php');

// Define categories for the artwork
$categories = ['drawings', 'paintings', 'photographs', 'sculptures', 'carvings'];

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $lot_number = $_POST['lot_number'];  // Lot number input
    $creator = ucwords($_POST['creator']);  // Creator name (capitalized)
    $category = ucfirst($_POST['category']);  // Category (capitalized)
    $date_of_creation = $_POST['date_of_creation'];  // Date of creation input
    $description = $_POST['item_description'];  // Description of the item
    $estimated_price = $_POST['estimated-price'];  // Estimated price input
    $auction_date = $_POST['auction-date'];  // Auction date input

    // Handle file upload for the item's image
    if (isset($_FILES['item_image']) && $_FILES['item_image']['error'] === UPLOAD_ERR_OK) {
        // Get the image name and prepare the target directory
        $image_name = basename($_FILES['item_image']['name']);
        $target_dir = 'images/';
        $target_file = $target_dir . uniqid() . '_' . $image_name;

        // Check if the target directory exists, if not, create it
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);  // Create directory with appropriate permissions
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['item_image']['tmp_name'], $target_file)) {
            $image_path = $target_file;  // Store the image path
        } else {
            // Show an error if the image upload fails
            echo "<script>alert('Failed to upload image.'); window.history.back();</script>";
            exit;
        }
    } else {
        // Show an error if no image is uploaded or there was an error
        echo "<script>alert('No image uploaded or upload error.'); window.history.back();</script>";
        exit;
    }

    // Insert the collected data into the database
    $insert = $Connection->prepare("INSERT INTO items (lot_number, creator, category, date_of_creation, description, estimated_price, auction_date, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $insert->execute([$lot_number, $creator, $category, $date_of_creation, $description, $estimated_price, $auction_date, $image_path]);

    // Show success message and redirect back to the "Add Item" page
    echo "<script>alert('Item added successfully!'); window.location.href='admin_panel.php?a=add_item';</script>";
    exit;
}
?>

<style>
    /* Styles for the Add Item form container */
    .add-item-form {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: calc(100vh - 80px);  /* Adjust height */
        padding: 20px;
        margin: 120px 20px 20px 20px;
    }

    /* Heading style for the form */
    .add-item-form h2 {
        margin-bottom: 20px;
        font-size: 2em;
        text-align: center;
        color: #333;
    }

    /* Style for the form container */
    .add-item-form form {
        min-width: 300px;
        max-width: 500px;
        width: 100%;
        padding: 20px;
        background-color: white;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Label styling for form inputs */
    .add-item-form label {
        display: block;
        margin: 15px 0 5px;
        font-weight: bold;
    }

    /* Styling for input fields, selects, and textareas */
    .add-item-form input[type="text"],
    .add-item-form input[type="date"],
    .add-item-form select,
    .add-item-form textarea,
    .add-item-form input[type="file"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 1em;
    }

    /* Styling for the textarea input */
    .add-item-form textarea {
        resize: vertical;
    }

    /* Styling for the file input (image upload) */
    .add-item-form input[type="file"] {
        padding: 10px;
        background-color: #f9f9f9;
    }

    /* Button styling */
    .add-item-form button {
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

    /* Button hover effect */
    .add-item-form button:hover {
        background-color: #0056b3;
    }
</style>

<!-- Form HTML structure -->
<div class="add-item-form">
    <form action="add_item.php" method="POST" enctype="multipart/form-data">
        <h2>Add New Item</h2>

        <!-- Lot Number input -->
        <label for="lot_number">Lot Number</label>
        <input type="text" id="lot_number" name="lot_number" value="<?= $_POST['lot_number'] ?? '' ?>" required>

        <!-- Creator input -->
        <label for="creator">Creator</label>
        <input type="text" id="creator" name="creator" value="<?= $_POST['creator'] ?? '' ?>" required>

        <!-- Category selection -->
        <label for="category">Category</label>
        <select id="category" name="category" required>
            <option value="" disabled <?= empty($_POST['category']) ? 'selected' : '' ?>>Select</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat ?>" <?= ($_POST['category'] ?? '') === $cat ? 'selected' : '' ?>>
                    <?= ucfirst($cat) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Date of creation input -->
        <label for="date_of_creation">Date of Creation</label>
        <input type="date" id="date_of_creation" name="date_of_creation" value="<?= $_POST['date_of_creation'] ?? '' ?>" required>

        <!-- Item description input -->
        <label for="item_description">Description</label>
        <textarea id="item_description" name="item_description" rows="5" required><?= $_POST['item_description'] ?? '' ?></textarea>

        <!-- Estimated price input -->
        <label for="estimated-price">Estimated Price(£)</label>
        <input type="text" id="estimated-price" name="estimated-price" value="<?= $_POST['estimated-price'] ?? '' ?>" required>

        <!-- Auction date input -->
        <label for="auction-date">Auction Date</label>
        <input type="date" id="auction-date" name="auction-date" value="<?= $_POST['auction-date'] ?? '' ?>" required>

        <!-- Image upload input -->
        <label for="item_image">Upload Image</label>
        <input type="file" id="item_image" name="item_image" required>

        <!-- Submit button -->
        <button type="submit">Add Item</button>
    </form>
</div>