<?php
// Include the database connection file
require ('./dbconnection.php');

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    // Redirect to admin login page if not logged in as admin
    header('Location: admin_login.php');
    exit;
}

// Prepare and execute the query to fetch archived items from the database
$stmt = $Connection->prepare("SELECT * FROM items WHERE isArchived = 1");
$stmt->execute();

// Fetch all the archived items from the database
$archivedItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if there are any archived items
if (count($archivedItems) > 0): ?>
    <!-- Display the items if there are archived items -->
    <div class="items-container">
        <?php foreach ($archivedItems as $item): ?>
            <div class="item-card">
                <!-- Display the item image -->
                <div class="item-image">
                    <img src="<?= htmlspecialchars($item['image']) ?>" alt="Item Image">
                </div>
                <div class="item-details">
                    <div class="item-info">
                        <!-- Display the item details -->
                        <h3>Lot Number: <?= htmlspecialchars($item['lot_number']) ?></h3>
                        <p><strong>Creator:</strong> <?= htmlspecialchars($item['creator']) ?></p>
                        <p><strong>Date Created:</strong> <?= htmlspecialchars($item['date_of_creation']) ?></p>
                        <p><strong>Category:</strong> <?= htmlspecialchars($item['category']) ?></p>
                        <p><strong>Auction Date:</strong> <?= htmlspecialchars($item['auction_date']) ?></p>
                        <p><strong>Estimated Price:</strong> £<?= htmlspecialchars($item['estimated_price']) ?></p>
                        <p><strong>Description:</strong> <?= htmlspecialchars($item['description']) ?></p>
                    </div>
                    <div class="buttons">
                        <!-- Provide a button to delete the item with a confirmation prompt -->
                        <a href="delete_item.php?id=<?= $item['id'] ?>&category=<?= urlencode($item['category']) ?>" onclick="return confirm('Are you sure you want to delete this item?')"><button>Delete</button></a>
                        <!-- Provide a button to unarchive the item -->
                        <a href="unarchive_item.php?id=<?= $item['id'] ?>"><button>Unarchive</button></a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <!-- Display a message if no archived items are found -->
    <p class="info-msg">No items found for this category.</p>
<?php endif; ?>