<?php
header("Content-Type: application/json"); // Set response to JSON

include "db_connect.php"; // Include database connection

if (!$conn) {
    echo json_encode(["success" => false, "message" => "Database connection failed"]);
    exit();
}

$query = "SELECT MAX(reservation_id) + 1 AS next_id FROM reservations";
$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $nextID = $row['next_id'] ?? 1; // Default to 1 if no reservations exist
    echo json_encode(["success" => true, "reservation_id" => $nextID]);
} else {
    echo json_encode(["success" => false, "message" => "Database query failed"]);
}

mysqli_close($conn);
?>
