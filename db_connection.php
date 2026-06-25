<?php
// Database connection settings
$servername = "localhost"; // Your MySQL server (often 'localhost' or IP address)
$username = "root";        // MySQL username (use your own credentials)
$password = "";            // MySQL password (use your own password)
$dbname = "hotel_db";     // Name of the database you are using

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $database);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If the connection is successful, you can use $conn in your other PHP scripts
?>
