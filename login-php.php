<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_db";

// $servername = "www.itechsolns.com";
// $username = "u469703722_root2";
// $password = "t9;xxwr[5cs";
// $dbname = "u469703722_hotel_db"; // Replace with your database name

// Start session
session_start();

// Connect to MySQL database
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize input
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));

    // Validate required fields
    if (empty($email) || empty($password)) {
        echo "Please enter both email and password.";
        exit();
    }

    // Query to check email and password directly
    $sql = "SELECT * FROM customer WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        // Valid email and password, set session variables
        $_SESSION['user_id'] = $user['id']; // Store user ID in session
        $_SESSION['user_name'] = $user['name']; // Store user name in session

        // Redirect to book.php
        header("Location: book.php");
        exit();
    } else {
        // Invalid email or password
        echo "Invalid email or password. Please try again.";
    }
}

// Close connection
mysqli_close($conn);
?>
