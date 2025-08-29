<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags for character encoding and responsive design -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Page title -->
    <title>Fotheby's Auction House</title>

    <!-- Internal CSS styles -->
    <style>
        /* Resetting default margin and padding, and setting box-sizing */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Basic body styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        /* Main content styling */
        main {
            padding: 20px;
            text-align: center;
            margin: 20px auto;
            max-width: 800px;
        }

        /* Link styling */
        a {
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Heading styles */
        h1 {
            font-size: 2.5em;
        }

        h2 {
            font-size: 2em;
            margin-bottom: 10px;
        }

        /* Paragraph styling */
        main p {
            font-size: 1.2em;
            margin-bottom: 20px;
            font-style: italic;
        }  
    </style>
</head>
<body>
    <!-- Include reusable header from external PHP file -->
    <?php include('./header.php') ?>

    <!-- Main content area -->
    <main>
        <!-- Welcome message -->
        <h2>Welcome to Fotheby's Auction House</h2>

        <!-- Brief introduction message -->
        <p>Discover unique pieces of art from renowned artists around the world.</p>

        <!-- Registration link to access the catalogue -->
        <a href="register.php">Register to access the catalogue</a>
    </main>

    <!-- Include reusable footer from external PHP file -->
    <?php include('./footer.php') ?>
</body>
</html>