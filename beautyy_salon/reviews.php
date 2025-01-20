<?php
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    $result = $conn->query("SELECT id FROM customers WHERE email='$email'");
    if ($result->num_rows > 0) {
        $customer = $result->fetch_assoc();
        $customer_id = $customer['id'];

        $conn->query("INSERT INTO reviews (customer_id, rating, review) VALUES ('$customer_id', '$rating', '$review')");
        echo "Review submitted successfully!";
    } else {
        echo "No customer found with this email.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Provide Review</title>
</head>
<body>
    <h1>Provide Review</h1>
    <form method="post">
        <label>Email:</label><input type="email" name="email" required><br>
        <label>Rating (1-5):</label><input type="number" name="rating" min="1" max="5" required><br>
        <label>Review:</label><textarea name="review" required></textarea><br>
        <button type="submit">Submit Review</button>
    </form>
</body>
</html>