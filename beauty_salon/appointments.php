<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $appointment_date = $_POST['appointment_date'];

    $sql = "INSERT INTO appointments (appointment_date)
            VALUES ('$appointment_date')";

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
    <title>Appointments</title>
</head>
<body>
    <form method="post" action="">
        Appointment Date: <input type="date" name="appointment_date" required><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>