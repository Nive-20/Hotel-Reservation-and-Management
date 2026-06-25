<?php
// Database connection
include 'db_connection.php';

// Read the invoice data from the client
$data = json_decode(file_get_contents("php://input"), true);

$reservation_id = $data['reservation_id'];
$name = $data['name'];
$total_amount = $data['total_amount'];
$payment_method = $data['payment_method'];
$discount = $data['discount'];

// Generate the invoice and save it in the database
$query = "INSERT INTO invoices (reservation_id, name, total_amount, payment_method, discount) 
          VALUES ('$reservation_id', '$name', '$total_amount', '$payment_method', '$discount')";

if (mysqli_query($conn, $query)) {
    echo json_encode([
        'success' => true,
        'message' => 'Invoice generated successfully.'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error generating invoice: ' . mysqli_error($conn)
    ]);
}
?>
