<!-- Header for the auction catalogue page (client side) -->
<?php
// Retrieve the 'category' parameter from the URL, defaulting to 'drawings' if not set
$categoryParam = strtolower($_GET['category'] ?? 'drawings');

// Store the category (capitalized) in the session for later use
$_SESSION['category'] = ucfirst($categoryParam);
?>

<style>
    /* Header styles */
    header {
        width: 100vw;
        background-color: #333;
        color: white;
    }

    /* Top row of the header - contains the website title, user welcome message, and logout link */
    .top-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        padding: 20px;
    }

    /* Bottom row of the header - contains the navigation and search form */
    .bottom-row {
        padding-left: 20px;
        padding-right: 20px;
        padding-top: 10px;
    }

    /* Navigation and search bar container styles */
    .nav-and-search {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    /* Navigation styles */
    nav {
        margin: 20px 0;
    }
    nav li {
        display: inline;
        list-style: none;
        color: white;
        text-decoration: none;
        font-size: 1.1em;
        margin-right: 2em;
    }
    nav a {
        text-decoration: none;
        color: white;
    }
    /* Hover and active state for navigation links */
    nav a:hover {
        text-decoration: underline;
        cursor: pointer;
    }
    nav a.active {
        color: #FFD700; /* Gold color for active category */
        font-weight: bold;
    }

    /* Search form styles */
    .search-form {
        display: flex;
        gap: 0.3em;
    }
    .search-form input[type="text"] {
        padding: 0.5em;
        border: 1px solid #ccc;
        border-radius: 12px;
    }
    .search-form button {
        padding: 0.5em;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 10px;
        cursor: pointer;
    }
    .search-form button:hover {
        background-color: #0056b3; /* Darker blue on hover */
    }

    /* Top row link and title styling */
    .top-row a {
        color: #007BFF;
        font-size: 1.2em;
        text-decoration: none;
    }
    .top-row a:hover {
        text-decoration: underline;
    }

    /* Styling for user welcome message */
    .top-row p {
        font-size: 1.2em;
        font-weight: 500;
    }

    /* Website title style */
    .top-row h1 {
        font-size: 2em;
        font-weight: 700;
        font-style: italic;
    }
</style>

<header>
    <!-- Top row: website title, welcome message, and logout link -->
    <div class="top-row">
        <h1>Fotheby's</h1>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p> <!-- Safe output of username -->
        <a href="logout.php">Logout</a>
    </div>

    <!-- Bottom row: navigation and search form -->
    <div class="bottom-row">
        <div class="nav-and-search">
            <nav>
                <!-- Navigation links for different categories with active class dynamically applied based on the selected category -->
                <li><a href="auction_catalogue.php?category=drawings" class="<?= $categoryParam === 'drawings' ? 'active' : '' ?>">Drawings</a></li>
                <li><a href="auction_catalogue.php?category=paintings" class="<?= $categoryParam === 'paintings' ? 'active' : '' ?>">Paintings</a></li>
                <li><a href="auction_catalogue.php?category=photographs" class="<?= $categoryParam === 'photographs' ? 'active' : '' ?>">Photographs</a></li>
                <li><a href="auction_catalogue.php?category=sculptures" class="<?= $categoryParam === 'sculptures' ? 'active' : '' ?>">Sculptures</a></li>
                <li><a href="auction_catalogue.php?category=carvings" class="<?= $categoryParam === 'carvings' ? 'active' : '' ?>">Carvings</a></li>
            </nav>

            <!-- Search form to search for creators in the auction catalog -->
            <form action="search.php" method="GET" class="search-form">
                <input type="text" name="q" placeholder="Search creators..." />
                <button type="submit">Search</button>
            </form>
        </div>
    </div>
</header>