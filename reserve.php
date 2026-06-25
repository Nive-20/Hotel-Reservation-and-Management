<?php
session_start();
$is_logged_in = isset($_SESSION['user_name']);

if (!$is_logged_in) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Room Reservation</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f5;
            margin: 0;
        }
        form {
            max-width: 400px;
            margin: auto;
            margin-top: 33px;
            background-color: #4a4a6a;
            color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
        input, select, button {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        h3 span {
            color: yellow;
            font-weight: bold;
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
                <li>
                    <?php if (isset($_SESSION['user_name'])): ?>
                        <a href="book.php">Book</a>
                    <?php else: ?>
                        <a href="#" class="disabled">Book</a>
                    <?php endif; ?>
                </li>
                <?php if ($is_logged_in): ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <form method="post" action="reservation_details.php">
        <label>Check-in Date:</label>
        <input type="date" name="checkin_date" min="<?php echo date('Y-m-d'); ?>" required onchange="calculateCost()">

        <label>Check-out Date:</label>
        <input type="date" name="checkout_date" min="<?php echo date('Y-m-d'); ?>" required onchange="calculateCost()">

        <label>Adults:</label>
        <select name="adults">
            <option value="1">1 Adult</option>
            <option value="2">2 Adults</option>
        </select>

        <label>Children:</label>
        <select name="children">
            <option value="0">0 Children</option>
            <option value="1">1 Child</option>
        </select>

        <label>Room Type:</label>
        <select name="room_type" onchange="updateDetails('room')">
            <option value='{"type":"Deluxe Room","cost":3500}'>Deluxe Room – ₹3500</option>
            <option value='{"type":"Superior Room","cost":5000}'>Superior Room – ₹5000</option>
            <option value='{"type":"Executive Suite","cost":7500}'>Executive Suite – ₹7500</option>
            <option value='{"type":"Grand Luxury","cost":8500}'>Grand Luxury – ₹8500</option>
        </select>

        <label>Bedding Type:</label>
        <select name="bedding_type" onchange="updateDetails('bedding')">
            <option value='{"type":"Single Bed","cost":500}'>Single Bed – ₹500</option>
            <option value='{"type":"Double Bed","cost":1500}'>Double Bed – ₹1500</option>
            <option value='{"type":"King Size","cost":2500}'>King Size – ₹2500</option>
        </select>

        <input type="hidden" id="num_days" name="num_days">

        <h3>Total Cost: ₹<span id="totalCost">0</span></h3>
        <h3>Initial Payment (45%): ₹<span id="initialPayment">0</span></h3>

        <label>Payment Method:</label>
        <select name="payment_method">
            <option value="Credit Card">Credit Card</option>
            <option value="UPI">UPI</option>
        </select>

        <button type="submit">Submit</button>
    </form>

    <script>
        let roomCost = 0;
        let beddingCost = 0;

        function updateDetails(type) {
            let value;
            if (type === 'room') {
                value = JSON.parse(document.querySelector('select[name="room_type"]').value);
                roomCost = value.cost;
            } else if (type === 'bedding') {
                value = JSON.parse(document.querySelector('select[name="bedding_type"]').value);
                beddingCost = value.cost;
            }

            calculateCost();
        }

        function calculateCost() {
            let checkinDate = new Date(document.querySelector('input[name="checkin_date"]').value);
            let checkoutDate = new Date(document.querySelector('input[name="checkout_date"]').value);
            let timeDiff = checkoutDate.getTime() - checkinDate.getTime();
            let days = Math.max(1, Math.ceil(timeDiff / (1000 * 3600 * 24))); // Ensure at least 1 day

            document.getElementById('num_days').value = days; 

            const totalCostPerDay = roomCost + beddingCost;
            const totalCost = totalCostPerDay * days;
            const initialPayment = totalCost * 0.45;

            document.getElementById('totalCost').innerText = totalCost;
            document.getElementById('initialPayment').innerText = Math.round(initialPayment);
        }

        document.querySelector('input[name="checkin_date"]').addEventListener('change', calculateCost);
        document.querySelector('input[name="checkout_date"]').addEventListener('change', calculateCost);
    </script>
</body>
</html>
