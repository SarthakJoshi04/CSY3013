<?php
// Start the session to manage user sessions
session_start();

// Include the database connection file
require('./dbconnection.php');

// Get the search query from the URL (GET parameter 'q') and sanitize it
$searchQuery = $_GET['q'] ?? ''; // Use null coalescing to provide default empty string
$searchQuery = htmlspecialchars(trim($searchQuery)); // Trim and escape HTML characters

// Initialize items array based on whether the search query is provided
if (!empty($searchQuery)) {
    // Prepare SQL to search for non-archived items where 'creator' matches search term
    $search = "SELECT * FROM items WHERE creator LIKE ? AND isArchived = 0";
    $stmt = $Connection->prepare($search);
    $stmt->execute(["%$searchQuery%"]); // Use wildcards for partial match
    $items = $stmt->fetchAll(); // Fetch all matching items
} else {
    $items = []; // No search query, return empty array
}

// Determine if the user is an admin for permission-based UI
$isAdmin = isset($_SESSION['username']) && $_SESSION['username'] === 'admin';

// Set the page title based on user role
$pageTitle = $isAdmin ? 'Admin Panel' : 'Auction Catalogue';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags for character encoding and responsiveness -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>

    <!-- Inline CSS for styling -->
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            overflow-x: hidden;
        }
        main {
            padding: 20px;
            margin: 20px auto;
        }
        .items-container {
            width: 100%;
            height: 100%;
            padding: 20px;
        }
        /* Card style for each item */
        .item-card {
            display: flex;
            width: 100%;
            margin-bottom: 30px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background: #fff;
        }
        .item-image {
            flex: 0 0 200px;
            height: 200px;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f9f9f9;
            overflow: hidden;
        }
        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 4px;
        }
        .item-details {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .item-info h3 {
            margin-top: 0;
            color: #333;
        }
        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        .buttons button {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
        }
        /* Style buttons for admin actions */
        .buttons a:first-child button {
            background: #4CAF50; /* Edit - Green */
            color: white;
        }
        .buttons a:nth-child(2) button {
            background: #f44336; /* Delete - Red */
            color: white;
        }
        .buttons a:last-child button {
            background: #2196F3; /* Archive - Blue */
            color: white;
        }
        .buttons button:hover {
            opacity: 0.9;
        }
        /* Info message when no results are found */
        p.info-msg {
            color: #555;
            font-size: 1.2em;
            margin: 20px;
        }
    </style>
</head>
<body>
    <!-- Include appropriate header based on user role -->
    <?php include $isAdmin ? 'admin_header.php' : 'catalogue_header.php'; ?>

    <main>
        <!-- Display the current search query -->
        <h1>Search Results for "<?php echo htmlspecialchars($searchQuery); ?>"</h1>

        <!-- Display matching items if found -->
        <?php if (count($items) > 0): ?>
            <div class="items-container">
                <?php foreach ($items as $item): ?>
                    <div class="item-card">
                        <!-- Display item image -->
                        <div class="item-image">
                            <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="Item Image">    
                        </div>
                        <!-- Display item details -->
                        <div class="item-details">
                            <div class="item-info">
                                <h3>Lot Number: <?php echo htmlspecialchars($item['lot_number']); ?></h3>
                                <p><strong>Creator:</strong> <?php echo htmlspecialchars($item['creator']); ?></p>
                                <p><strong>Date Created:</strong> <?php echo htmlspecialchars($item['date_of_creation']); ?></p>
                                <p><strong>Category:</strong> <?php echo htmlspecialchars($item['category']); ?></p>
                                <p><strong>Auction Date:</strong> <?php echo htmlspecialchars($item['auction_date']); ?></p>
                                <p><strong>Estimated Price:</strong> £<?php echo htmlspecialchars($item['estimated_price']); ?></p>
                                <p><strong>Description:</strong> <?php echo htmlspecialchars($item['description']); ?></p>
                            </div>

                            <!-- Display admin action buttons if logged in as admin -->
                            <div class="buttons">
                                <?php if ($isAdmin): ?>
                                    <!-- Edit button -->
                                    <a href="edit_item.php?id=<?= $item['id'] ?>&category=<?= urlencode($item['category']) ?>">
                                        <button>Edit</button>
                                    </a>
                                    <!-- Delete button with confirmation -->
                                    <a href="delete_item.php?id=<?= $item['id'] ?>&category=<?= urlencode($item['category']) ?>" onclick="return confirm('Are you sure you want to delete this item?')">
                                        <button>Delete</button>
                                    </a>
                                    <!-- Archive button -->
                                    <a href="archive_item.php?id=<?= $item['id'] ?>&category=<?= urlencode($item['category']) ?>">
                                        <button>Archive</button>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!-- Display message when no items match the search -->
            <p class="info-msg">No items found.</p>
        <?php endif; ?>
    </main>
</body>
</html>