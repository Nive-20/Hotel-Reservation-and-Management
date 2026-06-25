<?php
// Start the session
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_db";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize $is_logged_in based on the session
$is_logged_in = isset($_SESSION['user_name']);

// Fetch FAQs from the database
$sql = "SELECT * FROM faqs";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $faqs = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $faqs = [];
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        nav ul {
            list-style: none;
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
            font-weight: bold;
        }
        .faq-container {
            margin: 40px auto;
            max-width: 800px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .faq-item {
            background-color: white;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            padding: 15px;
        }
        .faq-item h3 {
            margin-bottom: 10px;
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
                <li><a href="book.php">Book</a></li>
                <?php if ($is_logged_in): ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <div class="container faq-container">
        <h1>Frequently Asked Questions</h1>
        <?php if (!empty($faqs)): ?>
            <?php foreach ($faqs as $faq): ?>
                <div class="faq-item">
                    <h3>Q: <?= htmlspecialchars($faq['question']) ?></h3>
                    <p>A: <?= nl2br(htmlspecialchars($faq['answer'])) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No FAQs are available at the moment.</p>
        <?php endif; ?>
    </div>
</body>
</html>
