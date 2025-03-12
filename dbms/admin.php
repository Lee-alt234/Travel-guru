<?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your username if different
$password = ""; // Replace with your password if applicable
$dbname = "holiday";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$show_options = false; // Variable to control showing the options

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];
    $action = $_POST['action'];

    // Handle Add action
    if ($action === 'add') {
        if ($type === 'package') {
            // Package data
            $name = $_POST['package_name'];
            $main_image = $_POST['main_image'];
            $hotel_name = $_POST['hotel_name'];
            $hotel_description = $_POST['hotel_description'];
            $cost = $_POST['package_cost'];
            $hotel_image = $_POST['hotel_image'];
            $stars = $_POST['stars'];

            // Insert into packages table
            $sql = "INSERT INTO packages (name, main, hotel, hoteld, cost, sec, stars)
                    VALUES ('$name', '$main_image', '$hotel_name', '$hotel_description', '$cost', '$hotel_image', '$stars')";

            if ($conn->query($sql) === TRUE) {
                $show_options = true; // Show options after success
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } elseif ($type === 'hotel') {
            // Hotel data
            $hotel_table = $_POST['hotel_table'];  // "goa" or "america"
            $hotel_name = $_POST['hotel_name'];
            $hotel_description = $_POST['hotel_description'];
            $hotel_price = $_POST['hotel_price'];
            $hotel_stars = $_POST['hotel_stars'];
            $hotel_image = $_POST['hotel_image'];

            // Insert into the selected hotel table (Goa or America)
            $sql = "INSERT INTO $hotel_table (hotel, address, price, stars, pic)
                    VALUES ('$hotel_name', '$hotel_description', '$hotel_price', '$hotel_stars', '$hotel_image')";

            if ($conn->query($sql) === TRUE) {
                $show_options = true; // Show options after success
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        /* Styling for form and buttons */
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
            background-color: bisque;
        }
        .form-container {
            max-width: 500px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #D4D4D4FF;
        }
        form label, .form-container select, .form-container input[type="text"], .form-container input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .delete-btn {
            background-color: #f44336;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<?php if ($show_options): ?>
    <h2>Product Added Successfully!</h2>
    <h3>What would you like to do next?</h3>

    <!-- Options after successful addition -->
    <button onclick="window.location.href='admin.php';">Add Another Product</button>
    <button onclick="window.location.href='index.html';">Go to Website</button>
    <button class="delete-btn" onclick="window.location.href='delete.php';">Delete</button>

<?php else: ?>
    <div class="form-container">
        <h2>Add Product</h2>
        <form method="post">
            <label>Select Type:</label>
            <select name="type" id="type" onchange="toggleFormFields()">
                <option value="package">Package</option>
                <option value="hotel">Hotel</option>
            </select>

            <label>Select Action:</label>
            <select name="action" id="action" onchange="toggleFormFields()">
                <option value="add">Add</option>
            </select>

            <!-- Package Fields -->
            <div id="package_fields">
                <label>Package Name:</label>
                <input type="text" name="package_name">

                <label>Main Image:</label>
                <input type="text" name="main_image">

                <label>Hotel Name:</label>
                <input type="text" name="hotel_name">

                <label>Hotel Description:</label>
                <input type="text" name="hotel_description">

                <label>Package Cost:</label>
                <input type="number" name="package_cost">

                <label>Hotel Image:</label>
                <input type="text" name="hotel_image">

                <label>Stars:</label>
                <input type="number" name="stars">
            </div>

            <!-- Hotel Fields -->
            <div id="hotel_fields" style="display: none;">
                <label>Select Hotel Table:</label>
                <select name="hotel_table">
                    <option value="goa">Goa</option>
                    <option value="america">America</option>
                </select>

                <label>Hotel Name:</label>
                <input type="text" name="hotel_name">

                <label>Description:</label>
                <input type="text" name="hotel_description">

                <label>Price:</label>
                <input type="number" name="hotel_price">

                <label>Stars:</label>
                <input type="number" name="hotel_stars">

                <label>Image:</label>
                <input type="text" name="hotel_image">
            </div>

            <button type="submit">Submit</button>
        </form>

        <!-- Delete Button -->
        <button class="delete-btn" onclick="window.location.href='delete.php';">Delete</button>
    </div>
<?php endif; ?>

<script>
function toggleFormFields() {
    var type = document.getElementById("type").value;
    var action = document.getElementById("action").value;

    // Show fields based on selected type and action
    document.getElementById("package_fields").style.display = (type === "package") ? "block" : "none";
    document.getElementById("hotel_fields").style.display = (type === "hotel") ? "block" : "none";
}
</script>

</body>
</html>
