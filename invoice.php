<?php
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

// Fetch the reservation ID from the GET request
$reservation_id = isset($_GET['reservation_id']) ? intval($_GET['reservation_id']) : 0;

if ($reservation_id > 0) {
    // Fetch reservation details
    $sql = "SELECT * FROM reservations WHERE reservation_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $reservation_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $reservation_details = $result->fetch_assoc();
    } else {
        die("No reservation found for the provided ID.");
    }

    $stmt->close();
} else {
    die("Invalid reservation ID.");
}

$conn->close();

// Calculate discount if total cost exceeds ₹75,000
$total_cost = $reservation_details['total_cost'];
$discount = ($total_cost > 75000) ? $total_cost * 0.15 : 0;
$final_amount = $total_cost - $discount;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - Reservation #<?= htmlspecialchars($reservation_id) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .invoice {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: white;
        }
        .invoice h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-details {
            margin: 20px 0;
            width: 100%;
        }
        .invoice-details th, .invoice-details td {
            text-align: left;
            padding: 8px 0;
        }
        .invoice-footer {
            text-align: center;
            margin-top: 20px;
        }
        .btn-print {
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-print:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="invoice">
        <h2>Invoice</h2>
        <table class="invoice-details">
            <tr>
                <th>Reservation ID:</th>
                <td><?= htmlspecialchars($reservation_details['reservation_id']) ?></td>
            </tr>
            <tr>
                <th>Customer ID:</th>
                <td><?= htmlspecialchars($reservation_details['customer_id']) ?></td>
            </tr>
            <tr>
                <th>Check-In Date:</th>
                <td><?= htmlspecialchars($reservation_details['checkin_date']) ?></td>
            </tr>
            <tr>
                <th>Check-Out Date:</th>
                <td><?= htmlspecialchars($reservation_details['checkout_date']) ?></td>
            </tr>
            <tr>
                <th>Adults:</th>
                <td><?= htmlspecialchars($reservation_details['adults']) ?></td>
            </tr>
            <tr>
                <th>Children:</th>
                <td><?= htmlspecialchars($reservation_details['children']) ?></td>
            </tr>
            <tr>
                <th>Room Type:</th>
                <td><?= htmlspecialchars($reservation_details['room_type_description']) ?></td>
            </tr>
            <tr>
                <th>Room Cost:</th>
                <td>₹<?= htmlspecialchars($reservation_details['room_type_cost']) ?></td>
            </tr>
            <tr>
                <th>Bedding Type:</th>
                <td><?= htmlspecialchars($reservation_details['bedding_type_description']) ?></td>
            </tr>
            <tr>
                <th>Bedding Cost:</th>
                <td>₹<?= htmlspecialchars($reservation_details['bedding_type_cost']) ?></td>
            </tr>
            <tr>
                <th>Total Cost:</th>
                <td>₹<?= htmlspecialchars($total_cost) ?></td>
            </tr>
            <?php if ($discount > 0) { ?>
            <tr>
                <th>Discount (15% Applied):</th>
                <td>-₹<?= number_format($discount, 2) ?></td>
            </tr>
            <tr>
                <th>Final Amount After Discount:</th>
                <td>₹<?= number_format($final_amount, 2) ?></td>
            </tr>
            <?php } ?>
            <tr>
                <th>Initial Payment:</th>
                <td>₹<?= htmlspecialchars($reservation_details['initial_payment']) ?></td>
            </tr>
            <tr>
                <th>Payment Method:</th>
                <td><?= htmlspecialchars($reservation_details['payment_method']) ?></td>
            </tr>
            <tr>
                <th>Status:</th>
                <td><?= htmlspecialchars($reservation_details['status']) ?></td>
            </tr>
        </table>
        <div class="invoice-footer">
            <button class="btn-print" onclick="window.print()">Print Invoice</button>
        </div>
    </div>
</body>
</html>
