<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $role = $_POST['role'];
    $experience = $_POST['experience'];
    $specialization = $_POST['specialization'];

    $sql = "INSERT INTO staff (name, role, experience, specialization)
            VALUES ('$name', '$role', '$experience', '$specialization')";

    if ($conn->query($sql) === TRUE) {
        echo "New staff member added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Staff Management</title>
</head>
<body>
    <form method="post" action="">
        Name: <input type="text" name="name" required><br>
        Role: <input type="text" name="role" required><br>
        Experience (years): <input type="number" name="experience" required><br>
        Specialization: <input type="text" name="specialization" required><br>
        <input type="submit" value="Add Staff">
    </form>
</body>
</html>