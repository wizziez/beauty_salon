<?php
include 'db_config.php';

$category = $_GET['category'] ?? '';

$query = "SELECT * FROM staff";
if ($category) {
    $query .= " WHERE category LIKE '%$category%'";
}

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Our Staff</title>
</head>
<body>
    <h1>Our Staff</h1>
    <form method="get" action="staff.php">
        <label for="category">Search by Category:</label>
        <input type="text" id="category" name="category" value="<?php echo $category; ?>">
        <button type="submit">Search</button>
    </form>
    <ul>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<li>{$row['name']} - {$row['category']}</li>";
            }
        } else {
            echo "<li>No staff members found.</li>";
        }
        ?>
    </ul>
</body>
</html>