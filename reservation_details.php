<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the user_name from the session
$user_name = $_SESSION['user_name'];

// Retrieve the customer_id based on user_name from the customer table
$sql_customer = "SELECT customer_id FROM customer WHERE name = ?";
$stmt = $conn->prepare($sql_customer);
$stmt->bind_param("s", $user_name);
$stmt->execute();
$result_customer = $stmt->get_result();

if ($result_customer->num_rows > 0) {
    $row = $result_customer->fetch_assoc();
    $customer_id = $row['customer_id'];
} else {
    echo "Error: Customer not found!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $checkin_date = $_POST['checkin_date'];
    $checkout_date = $_POST['checkout_date'];
    $adults = $_POST['adults'];
    $children = $_POST['children'];
$num_days = isset($_POST['num_days']) ? intval($_POST['num_days']) : 1; // Default 1 day

    $room_data = json_decode($_POST['room_type'], true);
    $room_type = $room_data['type'];
    $room_cost = $room_data['cost'];

    $bedding_data = json_decode($_POST['bedding_type'], true);
    $bedding_type = $bedding_data['type'];
    $bedding_cost = $bedding_data['cost'];

$total_cost = ($room_cost + $bedding_cost) * $num_days; // Correct cost calculation
    $initial_payment = $total_cost * 0.45;
    $payment_method = $_POST['payment_method'];
    $status = "Pending";

    $sql_reservation = "INSERT INTO reservations (customer_id, checkin_date, checkout_date, adults, children, room_type_description, room_type_cost, bedding_type_description, bedding_type_cost, total_cost, initial_payment, payment_method, status) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_reservation = $conn->prepare($sql_reservation);
    $stmt_reservation->bind_param(
        "sssssssssdsss",
        $customer_id,
        $checkin_date,
        $checkout_date,
        $adults,
        $children,
        $room_type,
        $room_cost,
        $bedding_type,
        $bedding_cost,
        $total_cost,
        $initial_payment,
        $payment_method,
        $status
    );

    if ($stmt_reservation->execute()) {
        header("Location: reserve_success.php");
    } else {
        echo "Error: " . $stmt_reservation->error;
    }
}

$stmt->close();
$conn->close();
?>
