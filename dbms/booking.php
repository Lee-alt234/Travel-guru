<?php 
// Database connection
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password is empty
$dbname = "holiday"; // Replace with your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if hotel_name and table parameters are passed
if (isset($_GET['hotel_name']) && isset($_GET['table'])) {
    // Sanitize inputs
    $hotel_name = $conn->real_escape_string($_GET['hotel_name']);
    $table = $conn->real_escape_string($_GET['table']);
    
    // Debugging message to show the passed parameters
    echo "<p>Hotel: $hotel_name, Table: $table</p>";

    // Construct SQL query dynamically based on table parameter (instead of region)
    $sql = "SELECT * FROM $table WHERE hotel = '$hotel_name'"; // Fetch from the specific table
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $hotel = $result->fetch_assoc();
    } else {
        echo "Hotel not found in the specified table.";
        exit;
    }
} else {
    // If parameters are missing, show an error
    echo "Hotel or table not specified. URL is missing parameters.";
    exit;
}

// Initialize variables for booking calculation
$bookingConfirmed = false;
$price = 0;

// Price calculation on form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $checkin_date = $_POST['checkin_date'];
    $checkout_date = $_POST['checkout_date'];

    // Convert date strings to DateTime objects
    $checkin = new DateTime($checkin_date);
    $checkout = new DateTime($checkout_date);

    // Calculate the difference between check-in and check-out
    $interval = $checkin->diff($checkout);
    $nights = $interval->days;

    if ($nights > 0) {
        // Calculate price based on number of nights
        $price = $hotel['price'] * $nights;
        $bookingConfirmed = true;
    } else {
        echo "<p style='color:red;'>Invalid dates! Check-out date must be later than check-in date.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }

        .hotel-details {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px;
        }

        .hotel-details img {
            width: 300px;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 20px;
        }

        .hotel-details h2 {
            font-size: 2em;
            color: #333;
        }

        .hotel-details p {
            color: #666;
            font-size: 1.2em;
        }

        .stars {
            color: gold;
        }

        .price {
            font-size: 1.5em;
            font-weight: bold;
            color: #28a745;
        }

        .booking-form {
            margin: 30px auto;
            width: 50%;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
        }

        .booking-form form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .booking-form input {
            padding: 10px;
            font-size: 1.1em;
            width: 100%;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .booking-form button {
            padding: 12px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1.2em;
            cursor: pointer;
        }

        .booking-form button:hover {
            background-color: #218838;
        }

        .booking-form h3 {
            font-size: 2em;
            color: #333;
        }

        .error-message {
            color: red;
            font-size: 1.2em;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="hotel-details">
    <img src="<?php echo $hotel['pic']; ?>" alt="<?php echo $hotel['hotel']; ?>">
    <div>
        <h2><?php echo $hotel['hotel']; ?></h2>
        <p><strong>Location:</strong> <?php echo $hotel['address']; ?></p>
        <p><strong class="stars"><?php echo str_repeat('★', $hotel['stars']); ?></strong></p>
        <p class="price">Price per Night: $<?php echo $hotel['price']; ?></p>
    </div>
</div>

<!-- Booking Form -->
<div class="booking-form">
    <?php if ($bookingConfirmed): ?>
        <h3>Booking Confirmed!</h3>
        <p>Total Price: $<?php echo $price; ?></p>
    <?php else: ?>
        <form method="POST" action="">
            <label for="checkin_date">Check-in Date:</label>
            <input type="date" id="checkin_date" name="checkin_date" required>
            <label for="checkout_date">Check-out Date:</label>
            <input type="date" id="checkout_date" name="checkout_date" required>
            <button type="submit">Confirm Booking</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>  
