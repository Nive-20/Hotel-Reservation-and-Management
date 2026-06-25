<?php
// Start the session
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_db";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize $is_logged_in based on the session
$is_logged_in = isset($_SESSION['user_name']);

// Redirect to login page if the user is not logged in
if (!$is_logged_in) {
    header("Location: login.php");
    exit(); // Stop further execution
}

// Initialize variables
$reservation_details = null;
$error = $success = null;

// Process the reservation ID form (to fetch details)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['fetch_details'])) {
    $reservation_id = mysqli_real_escape_string($conn, trim($_POST['reservation_id']));

    if (empty($reservation_id) || !is_numeric($reservation_id)) {
        $error = "Please enter a valid reservation ID.";
    } else {
        // Fetch reservation details
        $check_sql = "SELECT * FROM reservations WHERE reservation_id = ?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("i", $reservation_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $reservation_details = $result->fetch_assoc();
        } else {
            $error = "No reservation found with the given ID.";
        }
    }
}

// Process the checkout form
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['checkout'])) {
    $reservation_id = mysqli_real_escape_string($conn, trim($_POST['reservation_id']));

    if (empty($reservation_id) || !is_numeric($reservation_id)) {
        $error = "Please enter a valid reservation ID.";
    } else {
        // Check the current status of the reservation
        $check_sql = "SELECT status FROM reservations WHERE reservation_id = ?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("i", $reservation_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $current_status = $row['status'];

            if ($current_status === 'Checked-out') {
                $error = "This reservation is already signed out.";
            } else {
                // Update the status to "Checked-out"
                $update_sql = "UPDATE reservations SET status = 'Checked-out' WHERE reservation_id = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("i", $reservation_id);
                if ($update_stmt->execute()) {
                    $success = "Checkout successful. Thanks for staying in our hotel!";
                } else {
                    $error = "Error updating reservation.";
                }
            }
        } else {
            $error = "Invalid reservation number.";
        }
    }
}

// Close database connections
if (isset($stmt)) $stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blue Haven - Checkout</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('assets/images/checkin-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            text-align: center;
        }
        nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            background: rgba(0, 0, 0, 0.7);
            padding: 15px;
        }
        nav ul li {
            margin: 0 15px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 40px;
        }
        .section {
            background: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 900px;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: none;
        }
        button {
            background: #28a745;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
    </style>
    <script>
        function confirmCheckout() {
            return confirm("Are you sure you want to proceed with the checkout?");
        }
    </script>
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
                <?php if ($is_logged_in): ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <h1>Hotel Room Checkout</h1>
    <div class="container">
        <div class="section">
            <!-- Fetch Details Form -->
            <form method="POST" action="">
                <label for="reservation_id">Enter Reservation ID:</label>
                <input type="text" id="reservation_id" name="reservation_id" required>
                <button type="submit" name="fetch_details">Fetch Details</button>
            </form>
            
            <!-- Display Reservation Details -->
            <?php if ($reservation_details): ?>
                <div class="details">
                    <h3>Reservation Details</h3>
                    <p><strong>Customer ID:</strong> <?= htmlspecialchars($reservation_details['customer_id']) ?></p>
                    <p><strong>Room Type:</strong> <?= htmlspecialchars($reservation_details['room_type_description']) ?></p>
                    <p><strong>Bedding Type:</strong> <?= htmlspecialchars($reservation_details['bedding_type_description']) ?></p>
                    <p><strong>Status:</strong> <?= htmlspecialchars($reservation_details['status']) ?></p>
                </div>
                <!-- Checkout Form -->
                <form method="POST" action="" onsubmit="return confirmCheckout();">
                    <input type="hidden" name="reservation_id" value="<?= htmlspecialchars($reservation_details['reservation_id']) ?>">
                    <button type="submit" name="checkout">Checkout</button>
                </form>
                <!-- Download Invoice Button -->
                <form method="GET" action="invoice.php" style="margin-top: 20px;">
                    <input type="hidden" name="reservation_id" value="<?= htmlspecialchars($reservation_details['reservation_id']) ?>">
                    <button type="submit" class="btn btn-secondary">Download Invoice</button>
                </form>
            <?php endif; ?>
            
            <!-- Success/Error Messages -->
            <?php if ($success): ?>
                <h2><?= htmlspecialchars($success) ?></h2>
            <?php elseif ($error): ?>
                <h2><?= htmlspecialchars($error) ?></h2>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
