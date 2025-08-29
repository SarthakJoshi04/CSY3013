<?php
// Start the session to manage user sessions
session_start();

// Include the database connection file to interact with the database
require ('./dbconnection.php');

// Check if the user is logged in as admin by verifying the session variable 'username'
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    // Redirect to admin login page if the user is not logged in as admin
    header('Location: admin_login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        /* Basic styles for the admin panel page layout */
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
        .buttons a:first-child button {
            background: #4CAF50;
            color: white;
        }
        .buttons a:nth-child(2) button {
            background: #f44336;
            color: white;
        }
        .buttons a:last-child button {
            background: #2196F3;
            color: white;
        }
        .buttons button:hover {
            opacity: 0.9;
        }
        p.info-msg {
            color: #555;
            font-size: 1.2em;
            margin: 20px;
        }
    </style>
</head>
<body>
    <!-- Include the admin header -->
    <?php include './admin_header.php'; ?>
    
    <main>
        <?php
        // Prepare the SQL statement to retrieve items based on category and not archived
        $stmt = $Connection->prepare("SELECT * FROM items WHERE category = ? AND isArchived = 0");
        
        // Switch case to filter items by category (drawings, paintings, photographs, sculptures, carvings)
        switch ($activeParam) {
            case 'drawings':
                // Fetch items categorized as 'Drawings'
                $stmt->execute(['Drawings']);
                $drawings = $stmt->fetchAll(PDO::FETCH_ASSOC);
                // Display items if available
                if (count($drawings) > 0): ?>
                    <div class="items-container">
                        <?php foreach ($drawings as $item): ?>
                            <!-- Display each item as a card -->
                            <div class="item-card">
                                <div class="item-image">
                                    <img src="<?= htmlspecialchars($item['image']) ?>" alt="Item Image">
                                </div>
                                <div class="item-details">
                                    <div class="item-info">
                                        <h3>Lot Number: <?= htmlspecialchars($item['lot_number']) ?></h3>
                                        <p><strong>Creator:</strong> <?= htmlspecialchars($item['creator']) ?></p>
                                        <p><strong>Date Created:</strong> <?= htmlspecialchars($item['date_of_creation']) ?></p>
                                        <p><strong>Auction Date:</strong> <?= htmlspecialchars($item['auction_date']) ?></p>
                                        <p><strong>Estimated Price:</strong> £<?= htmlspecialchars($item['estimated_price']) ?></p>
                                        <p><strong>Description:</strong> <?= htmlspecialchars($item['description']) ?></p>
                                    </div>
                                    <div class="buttons">
                                        <!-- Buttons for editing, deleting, and archiving items -->
                                        <a href="edit_item.php?id=<?= $item['id'] ?>&category=<?= urlencode($item['category']) ?>"><button>Edit</button></a>
                                        <a href="delete_item.php?id=<?= $item['id'] ?>&category=<?= urlencode($item['category']) ?>" onclick="return confirm('Are you sure you want to delete this item?')"><button>Delete</button></a>
                                        <a href="archive_item.php?id=<?= $item['id'] ?>&category=<?= urlencode($item['category']) ?>"><button>Archive</button></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <!-- Show message if no items are found -->
                    <p class="info-msg">No items found for this category.</p>
                <?php endif; ?>
                <?php
                break;
            // Repeat similar code for other categories (paintings, photographs, sculptures, carvings)
            case 'paintings':
                $stmt->execute(['Paintings']);
                $paintings = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (count($paintings) > 0): ?>
                    <div class="items-container">
                        <?php foreach ($paintings as $item): ?>
                            <div class="item-card">
                                <div class="item-image">
                                    <img src="<?= htmlspecialchars($item['image']) ?>" alt="Item Image">
                                </div>
                                <div class="item-details">
                                    <div class="item-info">
                                        <h3>Lot Number: <?= htmlspecialchars($item['lot_number']) ?></h3>
                                        <p><strong>Creator:</strong> <?= htmlspecialchars($item['creator']) ?></p>
                                        <p><strong>Date Created:</strong> <?= htmlspecialchars($item['date_of_creation']) ?></p>
                                        <p><strong>Auction Date:</strong> <?= htmlspecialchars($item['auction_date']) ?></p>
                                        <p><strong>Estimated Price:</strong> £<?= htmlspecialchars($item['estimated_price']) ?></p>
                                        <p><strong>Description:</strong> <?= htmlspecialchars($item['description']) ?></p>
                                    </div>
                                    <div class="buttons">
                                        <a href="edit_item.php?id=<?= $item['id'] ?>&category=<?= urlencode($item['category']) ?>"><button>Edit</button></a>
                                        <a href="delete_item.php?id=<?= $item['id'] ?>&category=<?= urlencode($item['category']) ?>" onclick="return confirm('Are you sure you want to delete this item?')"><button>Delete</button></a>
                                        <a href="archive_item.php?id=<?= $item['id'] ?>&category=<?= urlencode($item['category']) ?>"><button>Archive</button></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="info-msg">No items found for this category.</p>
                <?php endif; ?>
                <?php
                break;
            case 'photographs':
                // Fetch items categorized as 'Photographs' and display
                $stmt->execute(['Photographs']);
                $photographs = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (count($photographs) > 0): ?>
                    <div class="items-container">
                        <?php foreach ($photographs as $item): ?>
                            <div class="item-card">
                                <div class="item-image">
                                    <img src="<?= htmlspecialchars($item['image']) ?>" alt="Item Image">
                                </div>
                                <div class="item-details">
                                    <div class="item-info">
                                        <h3>Lot Number: <?= htmlspecialchars($item['lot_number']) ?></h3>
                                        <p><strong>Creator:</strong> <?= htmlspecialchars($item['creator']) ?></p>
                                        <p><strong>Date Created:</strong> <?= htmlspecialchars($item['date_of_creation']) ?></p>
                                        <p><strong>Auction Date:</strong> <?= htmlspecialchars($item['auction_date']) ?></p>
                                        <p><strong>Estimated Price:</strong> £<?= htmlspecialchars($item['estimated_price']) ?></p>
                                        <p><strong>Description:</strong> <?= htmlspecialchars($item['description']) ?></p>
                                    </div>
                                    <div class="buttons">
                                        <a href="edit_item.php?id=<?= $item['id'] ?>&category=<?= urlencode($item['category']) ?>"><button>Edit</button></a>
                                        <a href="delete_item.php?id=<?= $item['id'] ?>&category=<?= urlencode($item['category']) ?>" onclick="return confirm('Are you sure you want to delete this item?')"><button>Delete</button></a>
                                        <a href="archive_item.php?id=<?= $item['id'] ?>&category=<?= urlencode($item['category']) ?>"><button>Archive</button></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="info-msg">No items found for this category.</p>
                <?php endif; ?>
                <?php
                break;
            case 'sculptures':
                // Fetch items categorized as 'Sculptures' and display
                $stmt->execute(['Sculptures']);
                $sculptures = $stmt->fetchAll(PDO::FETCH_ASSOC);
               if (count($sculptures) > 0): ?>
                    <div class="items-container">
                        <?php foreach ($sculptures as $item): ?>
                            <div class="item-card">
                                <div class="item-image">
                                    <img src="<?= htmlspecialchars($item['image']) ?>" alt="Item Image">
                                </div>
                                <div class="item-details">
                                    <div class="item-info">
                                        <h3>Lot Number: <?= htmlspecialchars($item['lot_number']) ?></h3>
                                        <p><strong>Creator:</strong> <?= htmlspecialchars($item['creator']) ?></p>
                                        <p><strong>Date Created:</strong> <?= htmlspecialchars($item['date_of_creation']) ?></p>
                                        <p><strong>Auction Date:</strong> <?= htmlspecialchars($item['auction_date']) ?></p>
                                        <p><strong>Estimated Price:</strong> £<?= htmlspecialchars($item['estimated_price']) ?></p>
                                        <p><strong>Description:</strong> <?= htmlspecialchars($item['description']) ?></p>
                                    </div>
                                    <div class="buttons">
                                        <a href="edit_item.php?id=<?= $item['id'] ?>&category=<?= urlencode($item['category']) ?>"><button>Edit</button></a>
                                        <a href="delete_item.php?id=<?= $item['id'] ?>&category=<?= urlencode($item['category']) ?>" onclick="return confirm('Are you sure you want to delete this item?')"><button>Delete</button></a>
                                        <a href="archive_item.php?id=<?= $item['id'] ?>&category=<?= urlencode($item['category']) ?>"><button>Archive</button></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="info-msg">No items found for this category.</p>
                <?php endif; ?>
                <?php
                break;
            case 'carvings':
                // Fetch items categorized as 'Carvings' and display
                $stmt->execute(['Carvings']);
                $carvings = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (count($carvings) > 0): ?>
                    <div class="items-container">
                        <?php foreach ($carvings as $item): ?>
                            <div class="item-card">
                                <div class="item-image">
                                    <img src="<?= htmlspecialchars($item['image']) ?>" alt="Item Image">
                                </div>
                                <div class="item-details">
                                    <div class="item-info">
                                        <h3>Lot Number: <?= htmlspecialchars($item['lot_number']) ?></h3>
                                        <p><strong>Creator:</strong> <?= htmlspecialchars($item['creator']) ?></p>
                                        <p><strong>Date Created:</strong> <?= htmlspecialchars($item['date_of_creation']) ?></p>
                                        <p><strong>Auction Date:</strong> <?= htmlspecialchars($item['auction_date']) ?></p>
                                        <p><strong>Estimated Price:</strong> £<?= htmlspecialchars($item['estimated_price']) ?></p>
                                        <p><strong>Description:</strong> <?= htmlspecialchars($item['description']) ?></p>
                                    </div>
                                    <div class="buttons">
                                        <a href="edit_item.php?id=<?= $item['id'] ?>&category=<?= urlencode($item['category']) ?>"><button>Edit</button></a>
                                        <a href="delete_item.php?id=<?= $item['id'] ?>&category=<?= urlencode($item['category']) ?>" onclick="return confirm('Are you sure you want to delete this item?')"><button>Delete</button></a>
                                        <a href="archive_item.php?id=<?= $item['id'] ?>&category=<?= urlencode($item['category']) ?>"><button>Archive</button></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="info-msg">No items found for this category.</p>
                <?php endif; ?>
                <?php
                break;
            // Include pages for adding and archiving items
            case 'add_item':
                include './add_item.php';
                break;
            case 'archive':
                include './archive.php';
                break;

            // Default case when no specific category is selected
            default:
                echo "<h1>Admin Panel</h1>";
        }
        ?>
    </main>
    
    <!-- Include the footer -->
    <?php include './footer.php'; ?>
</body>
</html>