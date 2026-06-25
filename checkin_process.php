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

// Process the check-in request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve user input
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));
    $reservation_id = isset($_POST['reservation_id']) ? intval($_POST['reservation_id']) : 0;

    // Step 1: Validate email and password against the customer table
    $sql_customer = "SELECT customer_id FROM customer WHERE email = ? AND password = ?";
    $stmt_customer = $conn->prepare($sql_customer);
    $stmt_customer->bind_param("ss", $email, $password);
    $stmt_customer->execute();
    $result_customer = $stmt_customer->get_result();

    if ($result_customer->num_rows > 0) {
        // If user is valid, get the customer ID
        $customer = $result_customer->fetch_assoc();
        $customer_id = $customer['customer_id'];

        // Step 2: Verify if the entered reservation ID belongs to this user and is pending
        $sql_reservation = "SELECT reservation_id FROM reservations WHERE reservation_id = ? AND customer_id = ? AND status = 'Pending'";
        $stmt_reservation = $conn->prepare($sql_reservation);
        $stmt_reservation->bind_param("ii", $reservation_id, $customer_id);
        $stmt_reservation->execute();
        $result_reservation = $stmt_reservation->get_result();

        if ($result_reservation->num_rows > 0) {
            // Update status to "Checked-in"
            $update_sql = "UPDATE reservations SET status = 'Checked-in' WHERE reservation_id = ?";
            $stmt_update = $conn->prepare($update_sql);
            $stmt_update->bind_param("i", $reservation_id);

            if ($stmt_update->execute()) {
                echo "<script>alert('Check-in successful for Reservation ID: $reservation_id.'); window.location.href='index.php';</script>";
            } else {
                echo "<script>alert('Error updating reservation status. Please try again.'); window.location.href='checkin.php';</script>";
            }

            $stmt_update->close();
        } else {
            // No valid pending reservation found
            echo "<script>alert('Invalid Reservation ID or no pending reservation found for this user.'); window.location.href='checkin.php';</script>";
        }

        $stmt_reservation->close();
    } else {
        // Invalid email or password
        echo "<script>alert('Invalid email or password. Please try again.'); window.location.href='checkin.php';</script>";
    }

    $stmt_customer->close();
}

// Close the database connection
$conn->close();
?>
