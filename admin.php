<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_db";

// Establish database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check database connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Initialize variables
$reservations_data = [];
$customers_data = [];
$data_type = "";
$error_message = "";
$is_logged_in = false;

// Ensure the logged-in state is reset on refresh
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the login form is submitted
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $conn->real_escape_string(trim($_POST['email']));
        $password = $conn->real_escape_string(trim($_POST['password']));

        $sql = "SELECT * FROM adminlogin WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            // Login successful
            $is_logged_in = true;
        } else {
            // Login failed
            $error_message = "Invalid email or password. Please try again.";
        }

        $stmt->close();
    }

    // Check if the logged-in user is submitting the data view form
    if (isset($_POST['logged_in']) && $_POST['logged_in'] === 'true') {
        $is_logged_in = true;

        // Fetch data based on radio button selection
        if (isset($_POST['data_type'])) {
            if ($_POST['data_type'] === 'reservations') {
                $data_type = "Reservations";
                $sql = "SELECT * FROM reservations";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $reservations_data = $result->fetch_all(MYSQLI_ASSOC);
                }
            } elseif ($_POST['data_type'] === 'customers') {
                $data_type = "Customers";
                $sql = "SELECT * FROM customer";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $customers_data = $result->fetch_all(MYSQLI_ASSOC);
                }
            }
        }
    }
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
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
        .container {
            margin-top: 5vh;
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
            </ul>
        </nav>
    </header>
    <div class="container mt-5">
        <?php if (!$is_logged_in): ?>
            <!-- Login Form -->
            <h2 class="text-center">Admin Login</h2>
            <form method="POST" action="admin.php" class="mt-4">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger mt-3"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>
        <?php else: ?>
            <!-- Admin Panel -->
            <h2 class="text-center">Admin Panel</h2>
            <form method="POST" action="admin.php" class="text-center my-4">
                <input type="hidden" name="logged_in" value="true">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="data_type" id="reservations" value="reservations"
                    <?php echo $data_type === "Reservations" ? "checked" : ""; ?>>
                    <label class="form-check-label" for="reservations">See Reservations List</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="data_type" id="customers" value="customers"
                    <?php echo $data_type === "Customers" ? "checked" : ""; ?>>
                    <label class="form-check-label" for="customers">See Customers List</label>
                </div>
                <button type="submit" class="btn btn-primary mt-2">View Data</button>
            </form>

            <?php if ($data_type === "Reservations"): ?>
                <h3 class="text-center">Reservations List</h3>
                <div class="table-responsive">
                    <table class="table table-dark table-striped table-hover">
                        <thead>
                            <tr>
                                <?php
                                if (!empty($reservations_data)) {
                                    foreach ($reservations_data[0] as $key => $value) {
                                        echo "<th>" . ucfirst($key) . "</th>";
                                    }
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reservations_data as $row): ?>
                                <tr>
                                    <?php foreach ($row as $value): ?>
                                        <td><?php echo htmlspecialchars($value); ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php elseif ($data_type === "Customers"): ?>
                <h3 class="text-center">Customers List</h3>
                <div class="table-responsive">
                    <table class="table table-dark table-striped table-hover">
                        <thead>
                            <tr>
                                <?php
                                if (!empty($customers_data)) {
                                    foreach ($customers_data[0] as $key => $value) {
                                        echo "<th>" . ucfirst($key) . "</th>";
                                    }
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($customers_data as $row): ?>
                                <tr>
                                    <?php foreach ($row as $value): ?>
                                        <td><?php echo htmlspecialchars($value); ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
