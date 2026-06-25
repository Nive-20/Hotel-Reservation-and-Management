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
    <title>About Us - Blue Heaven</title>
        <link rel="stylesheet" href="styles.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: url('assets/images/hotel-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #333;
        }
        .navbar {
            display: flex;
            justify-content: center;
            background: rgba(0, 0, 0, 0.7);
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            padding: 15px;
            font-size: 18px;
            
        }
      
        .container {
            max-width: 900px;
            background: rgba(255, 255, 255, 0.9);
            margin: 100px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
            color: #003366;
            margin-bottom: 20px;
        }
        h2 {
            margin-top: 20px;
            color: #333;
        }
        p {
            line-height: 1.6;
            font-size: 16px;
        }
        ul {
            list-style: none;
            padding-left: 0;
        }
        .container>ul li {
            font-size: 16px;
            margin: 10px 0;
        }
        .container>ul li::before {
            content: "✔️";
            color: #0073e6;
            font-weight: bold;
            margin-right: 8px;
        }
        .cta-button {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 12px;
            text-align: center;
            background: #28a745;
            color: white;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
        }
        .cta-button:hover {
            background: #218838;
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
                <!-- Always Display Book -->
                <li>
                    <?php if (isset($_SESSION['user_name'])): ?>
                        <a href="book.php">Book</a>
                    <?php else: ?>
                        <a href="#" class="disabled">Book</a>
                    <?php endif; ?>
                </li>
                
        <!-- Conditionally render the buttons -->
        <?php if ($is_logged_in): ?>
            <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="login.php">Login</a></li>
        <?php endif; ?>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h1>Welcome to <span style="color: #003366;">Blue Heaven</span></h1>
        <p>Blue Heaven is your trusted hotel reservation platform that offers seamless, hassle-free booking experiences for travelers worldwide.</p>

        <h2>Who We Are</h2>
        <p>We are a dedicated team focused on providing travelers with an easy, reliable, and secure way to book hotels online. Our platform is designed to offer a wide range of accommodations, from budget-friendly stays to luxury resorts.</p>

        <h2>What We Offer</h2>
        <ul>
            <li><strong>Instant & Secure Hotel Bookings</strong></li>
            <li><strong>A Variety of Stay Options</strong> – From budget to premium resorts.</li>
            <li><strong>Exclusive Deals & Discounts</strong> – Get the best offers.</li>
            <li><strong>24/7 Customer Support</strong> – Available anytime, anywhere.</li>
        </ul>

        <h2>Our Mission</h2>
        <p>Our mission is to make travel simple and worry-free by providing an easy-to-use platform that helps travelers find the best accommodation at the best price.</p>

        <h2>Why Choose Us?</h2>
        <ul>
            <li><strong>User-Friendly Booking System</strong></li>
            <li><strong>Best Price Guarantee</strong></li>
            <li><strong>Secure Payment Transactions</strong></li>
            <li><strong>Trusted by Thousands of Travelers</strong></li>
        </ul>

        <a href="reservation.php" class="cta-button">Book Your Stay Now</a>
    </div>

</body>
</html>
