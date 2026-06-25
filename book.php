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
    <title>Reservation - Blue Haven</title>
    <link rel="stylesheet" href="styles.css">
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
        <div class="reservation-container">
            <div class="hotel-name" style="display: inline; font-size: 25px;">
                Hello 
                <h1 style="display: inline; font-size: 50px;">
                    <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                </h1>, 
                <br>Welcome to Blue Haven
            </div>
            <p>Where you can experience luxury and comfort.</p>
            <div class="buttons">
                <a href="reserve.php?user_name=<?php echo urlencode($_SESSION['user_name']); ?>" class="btn">Reserve</a>
                <a href="checkin.php" class="btn">Check-In</a>
                <a href="checkout.php" class="btn">Check-Out</a>
                <a href="cancellation.php" class="btn">Cancellation</a>
            </div>
        </div>
    </main>

    <style>
        body {
            background: url('assets/images/reservation-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            font-family: Arial, sans-serif;
            color: white;
            text-align: center;
        }
        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
            background: rgba(0, 0, 0, 0.7);
            padding: 15px;
        }
        nav ul li {
            margin: 0 15px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
        }
        .reservation-container {
            margin-top: 20vh;
        }
        .hotel-name {
            margin: 10px 0;
        }
        p {
            font-size: 22px;
        }
        .buttons {
            margin-top: 20px;
        }
        .btn {
            display: inline-block;
            background: #007BFF;
            color: white;
            padding: 10px 20px;
            margin: 10px;
            text-decoration: none;
            font-size: 18px;
            border-radius: 5px;
        }
        .btn:hover {
            background: #0056b3;
        }
    </style>
</body>
</html>
