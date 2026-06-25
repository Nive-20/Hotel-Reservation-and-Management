<?php
// Start session
session_start();

// Check if the session variable for user login exists
$is_logged_in = isset($_SESSION['user_name']);

// If not logged in, redirect to login page
if ($is_logged_in) {
    header("Location: index.php");
    exit(); // Stop further execution
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
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
    
    <div class=" log-in-0">
        <div class="container mt-5 w-25 log-in bg-dark text-light">
        <h2 class="text-center mb-4">Login</h2>
        <form method="post" action="login-php.php">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
            <br><br>
            <span><a href="signup.html" style="color: white; font-weight: 500; text-decoration: none;">New user?</a></span>
        </form>
    </div>
    </div>
</body>
</html>
