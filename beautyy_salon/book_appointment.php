<?php
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $service_id = $_POST['service_id'];
    $staff_id = $_POST['staff_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];

    // Check if customer exists
    $result = $conn->query("SELECT id FROM customers WHERE email='$email'");
    if ($result->num_rows > 0) {
        $customer = $result->fetch_assoc();
        $customer_id = $customer['id'];
    } else {
        // Insert new customer
        $conn->query("INSERT INTO customers (name, phone, email) VALUES ('$name', '$phone', '$email')");
        $customer_id = $conn->insert_id;
    }

    // Check staff availability
    $result = $conn->query("SELECT COUNT(*) AS count FROM appointments WHERE staff_id='$staff_id' AND appointment_date='$appointment_date'");
    $count = $result->fetch_assoc()['count'];
    if ($count >= 3) {
        echo "Staff not available on this date.";
    } else {
        // Insert appointment
        $conn->query("INSERT INTO appointments (customer_id, staff_id, service_id, appointment_date, appointment_time) VALUES ('$customer_id', '$staff_id', '$service_id', '$appointment_date', '$appointment_time')");
        echo "Appointment booked successfully!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Appointment</title>
</head>
<body>
    <h1>Book Appointment</h1>
    <form method="post">
        <label>Name:</label><input type="text" name="name" required><br>
        <label>Phone:</label><input type="text" name="phone" required><br>
        <label>Email:</label><input type="email" name="email" required><br>
        <label>Service:</label>
        <select name="service_id">
            <?php
            $result = $conn->query("SELECT * FROM services");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>{$row['name']} - \${$row['price']}</option>";
            }
            ?>
        </select><br>
        <label>Preferred Staff:</label>
        <select name="staff_id">
            <option value="">No preference</option>
            <?php
            $result = $conn->query("SELECT * FROM staff");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>{$row['name']} ({$row['category']})</option>";
            }
            ?>
        </select><br>
        <label>Date:</label><input type="date" name="appointment_date" required><br>
        <label>Time:</label><input type="time" name="appointment_time" required><br>
        <button type="submit">Book Appointment</button>
    </form>
</body>
</html>