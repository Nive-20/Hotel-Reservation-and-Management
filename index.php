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
    <title>Blue Heaven - Home</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .disabled {
            pointer-events: none;
            color: grey;
        }
        .welcome-container {
            text-align: center;
            color: white;
            margin-top: 20vh;
        }
        h1 {
            font-size: 50px;
            margin: 0;
        }
        p {
            font-size: 22px;
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
        <div class="welcome-container">
            <h1>Blue Haven</h1>
            <p>Where you can experience luxury and comfort.</p>
        </div>
    </main>
</body>
</html>
