<?php
// Start session
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_db";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the reservation ID from the POST request
    $reservation_id = mysqli_real_escape_string($conn, trim($_POST['reservation_id']));

    if (!empty($reservation_id) && is_numeric($reservation_id)) {
        // Delete the reservation with the given ID
        $delete_sql = "DELETE FROM reservations WHERE reservation_id = ?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("i", $reservation_id);

        if ($stmt->execute()) {
            // Check if any rows were affected
            if ($stmt->affected_rows > 0) {
                // If a row was deleted, show success message
                echo "<script>alert('Cancellation successful.'); window.location.href='book.php';</script>";
            } else {
                // If no rows were deleted, the reservation ID was not found
                echo "<script>alert('Reservation ID not found. Please try again.'); window.location.href='cancellation.php';</script>";
            }
        } else {
            // If there was an error in execution
            echo "<script>alert('Error occurred while cancelling the reservation. Please try again.'); window.location.href='cancellation.php';</script>";
        }

        $stmt->close();
    } else {
        // If the reservation ID is invalid
        echo "<script>alert('Invalid reservation ID. Please try again.'); window.location.href='cancellation.php';</script>";
    }
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blue Haven - Cancellation</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .disabled {
            pointer-events: none;
            color: grey;
        }
        .welcome-container {
            text-align: center;
            color: white;
            margin-top: 20vh;
        }
        h1 {
            font-size: 50px;
            margin: 99px 0px 25px 0px;
            color: white;
            text-align: center;
        }
        p {
            font-size: 22px;
        }

        form {
            background: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            margin: auto;
            color: white;
        }

        input, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: none;
        }

        button {
            background: #dc3545;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">Our Legacy</a></li>
                <li><a href="contact.php">Help Desk</a></li>
                <li><a href="faq.php">FAQ</a></li>
                <li><a href="admin.php">Admin</a></li>
                <li><a href="book.php">Book</a></li>
                <!-- Conditionally render Login/Logout -->
                <?php if (isset($_SESSION['user_name'])): ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h1>Cancel Reservation</h1>
        <form method="POST" action="">
            <label for="reservation_id">Enter Reservation ID:</label>
            <input type="text" id="reservation_id" name="reservation_id" required placeholder="Reservation ID">
            <button type="submit">Cancel</button>
        </form>
    </div>
</body>
</html>
