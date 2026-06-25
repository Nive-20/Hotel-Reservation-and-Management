<?php
$servername = "localhost";  // Change if using a different host
$username = "root";
$password = "";
$database = "hotel_db";


// $servername = "www.itechsolns.com";
// $username = "u469703722_root2";
// $password = "t9;xxwr[5cs";
// $dbname = "u469703722_hotel_db"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("<h3 style='color:red;'>Connection failed: " . $conn->connect_error . "</h3>");
} else {
    echo "<h3 style='color:green;'>Database connected successfully!</h3>";
}

// Close connection
$conn->close();
?>
