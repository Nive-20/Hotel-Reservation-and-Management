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
    <title>Contact Us - Blue Haven</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to external CSS -->
    <style>
        /* Reset default margin & padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        main{
            display: flex;
            justify-content: center;
            align-items: center;
            height: 90vh;
        }
        /* Navigation Bar */
        .navbar {
            width: 100%;
            background: rgba(0, 0, 0, 0.7); /* Transparent black */
            padding: 15px 0;
            position: fixed;
            top: 0;
            left: 0;
            text-align: center;
            z-index: 1000;
        }

        .navbar ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
        }

        .navbar li {
            margin: 0 15px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 18px;
        }

        /* Contact Section */
        .contact-container {
            text-align: center;
            padding: 50px;
            background: rgba(255, 255, 255, 0.9);
            margin-top: 100px;
            width: 50%;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
        }

        .contact-container h2 {
            color: #333;
        }

        .contact-details {
            font-size: 18px;
            margin-top: 20px;
        }

        .contact-details a {
            color: #007bff;
            text-decoration: none;
        }

        .contact-details a:hover {
            text-decoration: underline;
        }

        /* Map Section */
        .map-container {
            text-align: center;
            margin-top: 30px;
        }

        iframe {
            width: 100%;
            max-width: 600px;
            height: 300px;
            border: none;
            border-radius: 10px;
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
  <main>
        <!-- Contact Details -->
    <div class="contact-container">
     
        <h2>Blue Haven - Contact Us </h2>
        <p class="contact-details">
            📞 Phone: <a href="tel:+919876543210">+91 98765 43210</a><br>
            ✉️ Email: <a href="mailto:info@blueheaven.com">info@blueheaven.com</a>
        </p>

        <!-- Google Maps Embed -->
        <div class="map-container">
            <h3>Our Location</h3>
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31102.87842750439!2d77.5945624!3d12.9715987!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bae1670e81f9a1d%3A0xf39f494340df8d02!2sBangalore%2C%20Karnataka%2C%20India!5e0!3m2!1sen!2sus!4v1649275991234!5m2!1sen!2sus" 
                allowfullscreen="" 
                loading="lazy">
            </iframe>
        </div>
    </div>
  </main>

</body>
</html>
