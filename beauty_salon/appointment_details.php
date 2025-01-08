<?php
include 'db_connect.php';

// Fetch staff for dropdown
$staff_result = $conn->query("SELECT staff_id, name FROM staff");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pay_date = $_POST['pay_date'];
    $pay_method = $_POST['pay_method'];
    $total_bill = $_POST['total_bill'];
    $appointment_id = $_POST['appointment_id'];
    $status = $_POST['status'];
    $staff_id = $_POST['staff_id'];

    $sql = "INSERT INTO appointment_details (pay_date, pay_method, total_bill, appointment_id, status, staff_id)
            VALUES ('$pay_date', '$pay_method', '$total_bill', '$appointment_id', '$status', '$staff_id')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Appointment Details</title>
</head>
<body>
    <form method="post" action="">
        Pay Date: <input type="date" name="pay_date" required><br>
        Pay Method: <input type="text" name="pay_method" required><br>
        Total Bill: <input type="number" step="0.01" name="total_bill" required><br>
        Appointment ID: <input type="number" name="appointment_id" required><br>
        Status: 
        <select name="status" required>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
        </select><br>
        Staff: 
        <select name="staff_id" required>
            <?php while($row = $staff_result->fetch_assoc()): ?>
                <option value="<?php echo $row['staff_id']; ?>"><?php echo $row['name']; ?></option>
            <?php endwhile; ?>
        </select><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>