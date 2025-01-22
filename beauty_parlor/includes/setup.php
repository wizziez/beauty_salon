<?php
require_once 'config.php'; // Include the configuration file

// Check if the database exists or is empty
$result = $conn->query("SHOW TABLES");
if ($result->num_rows == 0) {
    // Import the database SQL file
    $sqlFilePath = BASE_PATH . 'database/beauty_parlor.sql';

    if (file_exists($sqlFilePath)) {
        $sql = file_get_contents($sqlFilePath);
        if ($conn->multi_query($sql)) {
            echo "Database setup completed successfully.";
        } else {
            die("Error during database import: " . $conn->error);
        }
    } else {
        die("SQL file not found at: $sqlFilePath");
    }
} else {
    echo "Database is already set up.";
}
?>