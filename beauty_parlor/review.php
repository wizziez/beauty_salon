<?php include 'includes/header.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<div class="content">
    <main>
        <h1>Give a Review</h1>
        <form method="POST" action="review.php">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="rating">Rating (1-5):</label>
            <input type="number" id="rating" name="rating" min="1" max="5" required>
            
            <label for="comment">Comment:</label>
            <textarea id="comment" name="comment" required></textarea>
            
            <button type="submit">Submit Review</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $rating = $_POST['rating'];
            $comment = $_POST['comment'];

            // Fetch customer ID based on the provided name
            $sql = "SELECT cust_id FROM customer WHERE cust_name='$name'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $cust_id = $row['cust_id'];

                $rev_id = uniqid('R');
                $sql = "INSERT INTO review (rev_id, cust_id, rating, comment) VALUES ('$rev_id', '$cust_id', '$rating', '$comment')";
                if ($conn->query($sql) === TRUE) {
                    echo "<p class='success-message'>Review submitted successfully!</p>";
                } else {
                    echo "<p class='error-message'>Error: " . $sql . "<br>" . $conn->error . "</p>";
                }
            } else {
                echo "<p class='error-message'>No customer found with the provided name.</p>";
            }
        }
        ?>
    </main>
</div>
<?php include 'includes/footer.php'; ?>