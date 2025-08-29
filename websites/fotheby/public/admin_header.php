<!-- Header for the admin page -->
<?php
    // Retrieve the 'a' parameter from the URL, defaulting to 'drawings' if not set
    $activeParam =  strtolower($_GET['a'] ?? 'drawings');
    // Store the active section (capitalized) in the session
    $_SESSION['active'] = ucfirst($activeParam);
?>

<style>
    /* General header styling */
    header {
        background-color: #333;
        color: white;
        margin-bottom: 20px;
    }

    /* Styling for the top row of the header (logo and user info) */
    .top-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        padding: 20px;
    }

    /* Bottom row styling, which contains navigation and search */
    .bottom-row {
        padding-left: 20px;
        padding-right: 20px;
        padding-top: 10px;
    }
    
    /* Styling for the navigation and search form container */
    .nav-and-search {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    /* Navigation list styling */
    nav {
        margin: 20px 0;
    }

    /* List item for navigation links */
    nav li {
        display: inline;
        list-style: none;
        color: white;
        text-decoration: none;
        font-size: 1.1em;
        margin-right: 2em;
    }

    /* Link styling in the navigation menu */
    nav a {
        text-decoration: none;
        color: white;
    }

    /* Styling for hover effect on navigation links */
    nav a:hover {
        text-decoration: underline;
        cursor: pointer;
    }

    /* Active class styling for the current page (highlighted link) */
    nav a.active {
        color: #FFD700;
        font-weight: bold;
    }

    /* Styling for the search form */
    .search-form {
        display: flex;
        gap: 0.3em;
    }

    /* Styling for the search input field */
    .search-form input[type="text"] {
        padding: 0.5em;
        border: 1px solid #ccc;
        border-radius: 12px;
    }

    /* Styling for the search button */
    .search-form button {
        padding: 0.5em;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 10px;
        cursor: pointer;
    }

    /* Hover effect for the search button */
    .search-form button:hover {
        background-color: #0056b3;
    }

    /* Styling for the top-row links (like 'Logout') */
    .top-row a {
        color: #007BFF;
        font-size: 1.2em;
        text-decoration: none;
    }

    /* Hover effect for links in the top-row */
    .top-row a:hover {
        text-decoration: underline;
    }

    /* Styling for the welcome message and page title */
    .top-row p {
        font-size: 1.2em;
        font-weight: 500;
    }

    /* Styling for the header title */
    .top-row h1 {
        font-size: 2em;
        font-weight: 700;
        font-style: italic;
    }
</style>

<header>
    <!-- Header container with top-row for the title and user information -->
    <div class="top-row">
        <h1>Fotheby's</h1> <!-- Logo or website title -->
        <!-- Display the logged-in username -->
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        <!-- Logout link -->
        <a href="logout.php">Logout</a>
    </div>
    <div class="bottom-row">
        <!-- Navigation and search container -->
        <div class="nav-and-search">
            <!-- Navigation menu -->
            <nav>
                <!-- Active class is applied based on the current section selected via the URL 'a' parameter -->
                <li><a href="admin_panel.php?a=drawings" class="<?= $activeParam === 'drawings' ? 'active' : '' ?>">Drawings</a></li>
                <li><a href="admin_panel.php?a=paintings" class="<?= $activeParam === 'paintings' ? 'active' : '' ?>">Paintings</a></li>
                <li><a href="admin_panel.php?a=photographs" class="<?= $activeParam === 'photographs' ? 'active' : '' ?>">Photographs</a></li>
                <li><a href="admin_panel.php?a=sculptures" class="<?= $activeParam === 'sculptures' ? 'active' : '' ?>">Sculptures</a></li>
                <li><a href="admin_panel.php?a=carvings" class="<?= $activeParam === 'carvings' ? 'active' : '' ?>">Carvings</a></li>
                <li><a href="admin_panel.php?a=add_item" class="<?= $activeParam === 'add_item' ? 'active' : '' ?>">Add Item</a></li>
                <li><a href="admin_panel.php?a=archive" class="<?= $activeParam === 'archive' ? 'active' : '' ?>">Archive</a></li>
            </nav>
            <!-- Search form to search creators -->
            <form action="search.php" method="GET" class="search-form">
                <input type="text" name="q" placeholder="Search creators..." />
                <button type="submit">Search</button>
            </form>
        </div>
    </div>
</header>