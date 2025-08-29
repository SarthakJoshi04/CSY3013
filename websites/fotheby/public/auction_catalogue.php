<?php
// Start the session to manage user sessions
session_start();
// Including the 'dbconnection.php' file to establish a database connection
require ('./dbconnection.php');

// Check if the user is logged in; if not, redirect to login page
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auction Catalogue</title>
    <style>
        /* Resetting default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        /* Body styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            overflow-x: hidden;
        }
        /* Main container styling */
        main {
            padding: 20px;
            margin: 20px auto;
        }
        /* Container for items */
        .items-container {
            max-width: 100%;
            padding: 20px 0;
        }
        /* Styling for individual item cards */
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
        /* Item image styling */
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
        /* Item details area styling */
        .item-details {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        /* Item information header styling */
        .item-info h3 {
            margin-top: 0;
            color: #333;
        }
        /* Styling for the message if no items are found */
        p.info-msg {
            color: #555;
            font-size: 1.2em;
            margin: 20px;
        }
    </style>
</head>
<body>
    <!-- Include header section -->
    <?php include 'catalogue_header.php'; ?>

    <main>
        <?php
        // Prepare the SQL query to fetch items from the database based on category
        $stmt = $Connection->prepare("SELECT * FROM items WHERE category = ? AND isArchived = 0");
        
        // Check the selected category and execute the corresponding query
        switch ($categoryParam) {
            case 'drawings':
                $stmt->execute(['Drawings']);
                $drawings = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Display the items if available
                if (count($drawings) > 0): ?>
                    <div class="items-container">
                        <?php foreach ($drawings as $item): ?>
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
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <!-- Message if no items found -->
                    <p class="info-msg">No items found for this category.</p>
                <?php endif; ?>
                <?php
                break;
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
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="info-msg">No items found for this category.</p>
                <?php endif; ?>
                <?php
                break;
            default:
                echo "<h1>Auction Catalogue</h1>";
        }
        ?>
    </main>

    <!-- Include footer section -->
    <?php include 'footer.php'; ?>
</body>
</html>