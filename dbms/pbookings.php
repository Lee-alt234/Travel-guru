<?php
// Connect to the database
$servername = "localhost"; // Your server name
$username = "root";        // Your database username
$password = "";            // Your database password
$dbname = "holiday"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'package_name' is passed in the URL
if (isset($_GET['package_name'])) {
    $package_name = urldecode($_GET['package_name']);
    // Fetch the package details from the database using the package name
    $sql = "SELECT * FROM packages WHERE name = '$package_name'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the package details
        $row = $result->fetch_assoc();

        // Assign package details to variables
        $name = $row['name'];
        $main_image = $row['main'];
        $description = $row['description'];
        $hotel = $row['hotel'];
        $hotel_image = $row['sec'];
        $hotel_description = $row['hoteld'];
        $stars = $row['stars'];
        $cost = $row['cost'];
    } else {
        echo "Package not found.";
    }
} else {
    echo "No package selected.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Package Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .package-container {
            background-color: white;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
            max-width: 1200px;
        }
        .package-name {
            text-align: center;
            font-size: 3em;
            margin-bottom: 20px;
        }
        .package-details img {
            max-width: 100%;
            border-radius: 8px;
        }
        .description{
            font-size: 30px;
        }
        .main-image {
            text-align: center;
            margin-bottom: 20px;
        }
        .hotel-section {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        .hotel-image {
            width: 45%;
            padding-right: 20px;
        }
        .hotel-info {
            width: 45%;
        }
        .hotel-info h3 {
            text-align: center;
            font-size: 3em;
            margin-bottom: 10px;
        }
        .hotel-info p {
            font-size: 2em;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .cost {
            font-size: 1.5em;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
        }
        .booking-btn {
            display: block;
            width: 200px;
            margin: 30px auto;
            padding: 10px;
            background-color: #28a745;
            color: white;
            font-size: 1.2em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .booking-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="package-container">
    <!-- Package Name -->
    <div class="package-name"><?php echo $name; ?></div>

    <!-- Main Image -->
    <div class="main-image">
        <img src="<?php echo $main_image; ?>" alt="Main Image">
    </div>

    <!-- Description -->
    <div class="description">
        <p><?php echo $description; ?></p>
    </div>

    <!-- Hotel Info -->
    <div class="hotel-section">
        <!-- Hotel Image -->
        <div class="hotel-image">
            <img src="<?php echo $hotel_image; ?>" alt="Hotel Image">
        </div>
        
        <!-- Hotel Details -->
        <div class="hotel-info">
            <h3><?php echo $hotel; ?></h3>
            <p><?php echo $hotel_description; ?></p>
            <p><strong>Stars:</strong> <?php echo $stars; ?> echo $Stars</p>
        </div>
    </div>

    <!-- Cost -->
    <div class="cost">
        <p>Total Cost: $<?php echo $cost; ?></p>
    </div>

    <!-- Booking Button -->
    <form action="booking_confirmation.php" method="POST">
        <input type="hidden" name="package_name" value="<?php echo $name; ?>">
        <input type="hidden" name="cost" value="<?php echo $cost; ?>">
        <button type="submit" class="booking-btn">Booking Confirmation</button>
    </form>
</div>

</body>
</html>
