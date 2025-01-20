<?php
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['email'])) {
    $email = $_GET['email'];
    $result = $conn->query("SELECT * FROM customers WHERE email='$email'");
    if ($result->num_rows > 0) {
        $customer = $result->fetch_assoc();
        $customer_id = $customer['id'];

        $result = $conn->query("SELECT a.*, s.name AS service_name, st.name AS staff_name FROM appointments a JOIN services s ON a.service_id = s.id JOIN staff st ON a.staff_id = st.id WHERE a.customer_id='$customer_id'");
        echo "<h1>Appointment History for {$customer['name']}</h1>";
        while ($row = $result->fetch_assoc()) {
            echo "<p>Service: {$row['service_name']}, Staff: {$row['staff_name']}, Date: {$row['appointment_date']}, Time: {$row['appointment_time']}</p>";
        }
    } else {
        echo "No customer found with this email.";
    }
} else {
    echo "Please provide an email address.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Appointment History</title>
</head>
<body>
    <h1>View Appointment History</h1>
    <form method="get" action="history.php">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">View History</button>
    </form>
</body>
</html>