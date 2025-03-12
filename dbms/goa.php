<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "holiday";


$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM goa"; 
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotels in Goa</title> <!-- Updated title -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F7E8FFFF;
        }

        .hotel-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .hotel-box {
            width: 80%;
            max-width: 900px;
            height: 250px;
            margin: 10px 0;
            background-color: #fff;
            display: flex;
            align-items: center;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .hotel-box img {
            width: 200px;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 20px;
        }

        .hotel-info {
            flex: 1;
            font-size: 1.1em;
        }

        .hotel-info h3 {
            font-size: 1.5em;
            color: #333;
        }

        .hotel-info p {
            color: #666;
        }

        .hotel-info .stars {
            color: gold;
            font-size: 1.3em;
        }

        .hotel-info .price {
            font-size: 1.4em;
            font-weight: bold;
            color: green;
        }

        .book-now-btn {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            margin-top: 10px;
        }

        .book-now-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<h1 style="text-align: center; margin: 30px;">Available Hotels in Goa</h1> <!-- Updated header -->

<div class="hotel-container">
    <?php
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo '<div class="hotel-box">
                    <img src="' . $row['pic'] . '" alt="' . $row['hotel'] . '">
                    <div class="hotel-info">
                        <h3>' . $row['hotel'] . '</h3>
                        <p><strong>Location:</strong> ' . $row['address'] . '</p>
                        <p><strong class="stars">' . str_repeat('★', $row['stars']) . '</strong></p>
                        <p class="price">Price per Night: $' . $row['price'] . '</p>
                        <a href="booking.php?hotel_name=' . urlencode($row['hotel']) . '&table=goa" class="book-now-btn">Book Now</a>
                    </div>
                </div>';
        }
    } else {
        echo "No hotels found.";
    }
    $conn->close();
    ?>
</div>

</body>
</html>
