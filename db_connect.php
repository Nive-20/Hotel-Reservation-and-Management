<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$database = "hotel_db";

// $servername = "www.itechsolns.com";
// $username = "u469703722_root2";
// $password = "t9;xxwr[5cs";
// $dbname = "u469703722_hotel_db"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
