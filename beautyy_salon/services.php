<?php
include 'db_config.php';

$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';

$query = "SELECT * FROM services WHERE name LIKE '%$search%'";
if ($category) {
    $query .= " AND category='$category'";
}

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Explore Services</title>
</head>
<body>
    <h1>Explore Services</h1>
    <form method="get">
        <label>Search:</label><input type="text" name="search" value="<?php echo $search; ?>"><br>
        <label>Category:</label><input type="text" name="category" value="<?php echo $category; ?>"><br>
        <button type="submit">Search</button>
    </form>
    <ul>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<li>{$row['name']} - \${$row['price']} <a href='book_appointment.php'>Book Appointment</a></li>";
        }
        ?>
    </ul>
</body>
</html>