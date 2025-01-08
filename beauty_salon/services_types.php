<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $service_type_name = $_POST['service_type_name'];
    $service_type_details = $_POST['service_type_details'];

    $sql = "INSERT INTO service_types (service_type_name, service_type_details)
            VALUES ('$service_type_name', '$service_type_details')";

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
    <title>Service Types</title>
</head>
<body>
    <form method="post" action="">
        Service Type Name: <input type="text" name="service_type_name" required><br>
        Service Type Details: <textarea name="service_type_details" required></textarea><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>