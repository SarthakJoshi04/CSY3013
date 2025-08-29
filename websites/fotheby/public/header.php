<style>
    /* Styling for the header element */
    header {
        background-color: #333;
        color: white;
        text-align: center;
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
    }
    /* Styling for the navigation section */
    nav {
        margin: 20px 0;
    }
    /* Styling for each navigation list item */
    nav li {
        display: inline;
        margin: 0 15px;
        color: white;
        text-decoration: none;
        font-size: 1.1em;
    }
    nav a {
        color: #007BFF;
        text-decoration: none;
    }
    nav a:hover {
        text-decoration: underline;
    }
    nav li:hover {
        text-decoration: underline;
        cursor: pointer;
    }
</style>

<!-- Header Section -->
<header>
    <!-- Main title of the auction house -->
    <h1>Fotheby's Auction House</h1>

    <!-- Navigation menu -->
    <nav>
        <!-- Home link -->
        <li><a href="index.php">Home</a></li>

        <!-- Client login link -->
        <li><a href="login.php">Client</a></li>

        <!-- Admin login link -->
        <li><a href="admin_login.php">Admin</a></li>
    </nav>
</header>