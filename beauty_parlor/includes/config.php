<?php
// Dynamically define the project's root path and base URL
define('BASE_PATH', dirname(DIR) . '/'); // Root directory of the project
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/beauty_parlor/'); // Project URL

// Database configuration
define('DB_HOST', 'localhost'); // Change only if using a remote database
define('DB_USER', 'root');      // Default XAMPP username
define('DB_PASS', '');          // Default XAMPP password
define('DB_NAME', 'beauty_parlor'); // Database name

// Error reporting (Disable for production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Establish a database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check if the database connection was successful
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>