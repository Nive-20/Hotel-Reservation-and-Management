<?php
// Database connection
include 'db_connection.php';

if (isset($_GET['reservation_id'])) {
    $reservation_id = $_GET['reservation_id'];

    $query = "SELECT * FROM reservations WHERE reservation_id = '$reservation_id'";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $reservation = mysqli_fetch_assoc($result);
        echo json_encode([
            'success' => true,
            'reservation' => $reservation
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Reservation not found.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Reservation ID not provided.'
    ]);
}
?>
