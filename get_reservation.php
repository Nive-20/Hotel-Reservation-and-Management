<?php
header("Content-Type: application/json");
include 'db_connect.php';

$response = ["success" => false, "message" => ""];

if (isset($_GET['reservation_id'])) {
    $reservation_id = $_GET['reservation_id'];

    $sql = "SELECT * FROM reservations WHERE reservation_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $reservation_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $response = [
            "success" => true,
            "reservation_id" => $row["reservation_id"],
            "name" => $row["customer_name"],
            "phone" => $row["phone"],
            "email" => $row["email"],
            "checkin_date" => $row["checkin_date"],
            "checkout_date" => $row["checkout_date"],
            "room_type" => $row["room_type"],
            "bedding_type" => $row["bedding_type"],
            "total_cost" => $row["total_cost"],
            "initial_payment" => $row["initial_payment"],
            "payment_method" => $row["payment_method"],
            "status" => $row["status"]
        ];
    } else {
        $response["message"] = "❌ Reservation Not Found!";
    }

    $stmt->close();
} else {
    $response["message"] = "❌ Invalid Request!";
}

$conn->close();
echo json_encode($response);
