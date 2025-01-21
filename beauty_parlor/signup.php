<?php include 'includes/header.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<div class="content">
    <main>
        <h1>Signup</h1>
        <form method="POST" action="signup.php">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required>
            
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>
            
            <button type="submit">Signup</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $location = $_POST['location'];

            // Ensure the database connection is established
            if (isset($conn)) {
                $cust_id = uniqid('C');
                $sql = "INSERT INTO customer (cust_id, cust_name, cust_phone, cust_mail, cust_loc) VALUES ('$cust_id', '$name', '$phone', '$email', '$location')";
                if ($conn->query($sql) === TRUE) {
                    echo "<p class='success-message'>Signup successful! Your Customer ID is $cust_id</p>";
                } else {
                    echo "<p class='error-message'>Error: " . $sql . "<br>" . $conn->error . "</p>";
                }
            } else {
                echo "<p class='error-message'>Database connection failed.</p>";
            }
        }
        ?>
    </main>
</div>
<?php include 'includes/footer.php'; ?>