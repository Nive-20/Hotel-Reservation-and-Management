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

// Connect to MySQL database
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect form data and sanitize inputs
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));
    $address = mysqli_real_escape_string($conn, trim($_POST['address']));
    $age = intval($_POST['age']);
    $gender = mysqli_real_escape_string($conn, trim($_POST['gender']));
    $aadhaar = mysqli_real_escape_string($conn, trim($_POST['aadhaar']));

    // Validate required fields
    if (empty($name) || empty($phone) || empty($email) || empty($password) || empty($age) || empty($gender)) {
        echo "Please fill in all required fields.";
    } else {
        // Hash the password
        // $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert data into the customer table
        $sql = "INSERT INTO customer (name, phone, email, password, address, age, gender, aadhaar) 
                VALUES ('$name', '$phone', '$email', '$password', '$address', '$age', '$gender', '$aadhaar')";

        if (mysqli_query($conn, $sql)) {
            // Redirect to the login page after successful insertion
            header("Location: login.php");
            exit(); // Ensure no further code is executed
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>
