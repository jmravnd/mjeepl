<?php
// Database connection settings
$host = 'localhost';     // Host name (change if using a different host)
$dbname = 'mjeepl';      // Database name
$username = 'root';      // Database username (default is usually 'root')
$password = '';          // Database password (default is usually empty)

// Create connection
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Optional: Set character set to UTF-8
    $conn->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();  // Stop script execution if connection fails
}
?>
