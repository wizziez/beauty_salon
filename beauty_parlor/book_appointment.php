<?php include 'includes/header.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<main>
    <h1>Book an Appointment</h1>
    <form method="POST" action="book_appointment.php">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" required>
        
        <label for="service">Service:</label>
        <select id="service" name="service" required>
            <?php
            $sql = "SELECT * FROM services";
            $result = $conn->query($sql);

            while($row = $result->fetch_assoc()) {
                echo "<option value='{$row['sid']}'>{$row['sname']} - {$row['sprice']} BDT</option>";
            }
            ?>
        </select>
        
        <label for="staff">Preferred Staff (optional):</label>
        <select id="staff" name="staff">
            <option value="">No Preference</option>
            <?php
            $sql = "SELECT * FROM staff";
            $result = $conn->query($sql);

            while($row = $result->fetch_assoc()) {
                echo "<option value='{$row['staff_id']}'>{$row['staff_name']} - {$row['staff_role']}</option>";
            }
            ?>
        </select>
        
        <label for="app_date">Appointment Date:</label>
        <input type="date" id="app_date" name="app_date" required>
        
        <label for="pay_method">Payment Method:</label>
        <select id="pay_method" name="pay_method" required>
            <option value="Cash">Cash</option>
            <option value="bKash">bKash</option>
            <option value="Credit Card">Credit Card</option>
            <option value="Nagad">Nagad</option>
            <option value="Rocket">Rocket</option>
        </select>
        
        <button type="submit">Book Appointment</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $location = $_POST['location'];
        $service = $_POST['service'];
        $staff = $_POST['staff'];
        $app_date = $_POST['app_date'];
        $pay_method = $_POST['pay_method'];

        // Check if customer already exists
        $sql = "SELECT cust_id FROM customer WHERE cust_phone='$phone' AND cust_mail='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $cust_id = $row['cust_id'];
        } else {
            // Insert new customer
            $cust_id = uniqid('C');
            $sql = "INSERT INTO customer (cust_id, cust_name, cust_phone, cust_mail, cust_loc) VALUES ('$cust_id', '$name', '$phone', '$email', '$location')";
            $conn->query($sql);
        }

        // Check if staff has less than 3 appointments on the selected date
        if ($staff) {
            $sql = "SELECT COUNT(*) as count FROM appointment_staff WHERE staff_id='$staff' AND app_id IN (SELECT app_id FROM appointment WHERE app_date='$app_date')";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();

            if ($row['count'] >= 3) {
                echo "<p class='error-message'>Selected staff is fully booked on this date. Please choose another staff or date.</p>";
                exit;
            }
        }

        // Insert appointment
        $app_id = uniqid('AP');
        $sql = "INSERT INTO appointment (app_id, app_date, cust_id) VALUES ('$app_id', '$app_date', '$cust_id')";
        $conn->query($sql);

        // Insert appointment details
        $pay_id = uniqid('P');
        $total_bill = 0;
        $sql = "SELECT sprice FROM services WHERE sid='$service'";
        $result = $conn->query($sql);
        if ($row = $result->fetch_assoc()) {
            $total_bill = $row['sprice'];
        }
        $sql = "INSERT INTO appointment_details (pay_id, app_id, cust_id, pay_date, pay_method, total_bill, status, app_date) VALUES ('$pay_id', '$app_id', '$cust_id', NOW(), '$pay_method', '$total_bill', 'Pending', '$app_date')";
        $conn->query($sql);

        // Insert appointment services
        $sql = "INSERT INTO appointment_services (app_id, sid, staff_id) VALUES ('$app_id', '$service', '$staff')";
        $conn->query($sql);

        // Insert appointment staff
        if ($staff) {
            $sql = "INSERT INTO appointment_staff (app_id, staff_id) VALUES ('$app_id', '$staff')";
            $conn->query($sql);
        }

        echo "<p class='success-message'>Appointment has been booked successfully!</p>";
    }
    ?>
</main>

<?php include 'includes/footer.php'; ?>