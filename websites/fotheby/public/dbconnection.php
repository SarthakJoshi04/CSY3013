<?php
// Database connection parameters
$servername = 'mysql';          // Server name or IP address where the database is hosted
$username = 'root';           // Database username
$password = 'root';           // Database password
$databasename = 'fotheby';   // Name of the database

try {
    // Creating a new PDO (PHP Data Objects) connection
    $Connection = new PDO('mysql:dbname=' . $databasename . ';host=' . $servername, $username, $password);
} catch (PDOException $e) {
    // Handle connection errors
}