<?php
// Start session
session_start();

// Check if the session variable for user login exists
$is_logged_in = isset($_SESSION['user_name']);

// If not logged in, redirect to login page
if (!$is_logged_in) {
    header("Location: login.php");
    exit(); // Stop further execution
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Check-In</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* General body styling */
        body {
            background: url('assets/images/reservation-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            font-family: Arial, sans-serif;
            color: white;
            text-align: center;
        }
        main{
            display: flex;
            justify-content: center;
            align-items: center;
            height: 90vh;
        }

        /* Form container styling */
        .fform {
            width: 100%;
            max-width: 400px;
            background-color: #4a4a6a;
            color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        /* Form elements */
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Responsive design for smaller screens */
        @media (max-width: 500px) {
            .fform {
                padding: 15px;
            }

            h2 {
                font-size: 18px;
            }

            input, button {
                padding: 8px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
     <header>
        <nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">Our Legacy</a></li>
        <li><a href="contact.php">Help Desk</a></li>
        <li><a href="faq.php">FAQ</a></li>
        <li><a href="admin.php">Admin</a></li>
        
        <!-- Conditionally render the buttons -->
        <?php if ($is_logged_in): ?>
            <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="login.php">Login</a></li>
        <?php endif; ?>
    </ul>
</nav>

    </header>
    <main>
        <div class="fform">
        <!-- Form for customer check-in -->
        <form method="POST" action="checkin_process.php">
            <h2>Customer Check-In</h2>
            
            <!-- Email input field -->
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required placeholder="Enter your email">
            
            <!-- Password input field -->
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required placeholder="Enter your password">

            <!-- Reservation ID input field -->
            <label for="reservation_id">Reservation ID:</label>
            <input type="text" id="reservation_id" name="reservation_id" required placeholder="Enter Reservation ID">
            
            <!-- Submit button -->
            <button type="submit">Check In Now</button>
        </form>
    </div>
    </main>
</body>
</html>
