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
    $deleted = false;

    // Handle Delete action
    if ($type === 'package') {
        $package_name = $_POST['package_name'];

        // Delete from packages table based on package name
        $sql = "DELETE FROM packages WHERE name='$package_name'";

        if ($conn->query($sql) === TRUE) {
            $deleted = true;
        } else {
            echo "Error: " . $conn->error;
        }
    } elseif ($type === 'hotel') {
        $hotel_table = $_POST['hotel_table']; // "goa" or "america"
        $hotel_name = $_POST['hotel_name'];

        // Delete from the selected hotel table based on hotel name
        $sql = "DELETE FROM $hotel_table WHERE hotel='$hotel_name'";

        if ($conn->query($sql) === TRUE) {
            $deleted = true;
        } else {
            echo "Error: " . $conn->error;
        }
    }

    if ($deleted) {
        $show_options = true; // Show options after successful deletion
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>
    <style>
        /* Styling for form and buttons */
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        .form-container {
            max-width: 500px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        form label, .form-container select, .form-container input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #d32f2f;
        }
        .option-btn {
            background-color: #4CAF50;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<?php if ($show_options): ?>
    <h2>Product Deleted Successfully!</h2>
    <h3>What would you like to do next?</h3>

    <!-- Options after successful deletion -->
    <button class="option-btn" onclick="window.location.href='index.html';">Go to Website</button>
    <button class="option-btn" onclick="window.location.href='admin.php';">Add Another Product</button>
    <button class="option-btn" onclick="window.location.href='delete.php';">Delete Another Product</button>

<?php else: ?>
    <div class="form-container">
        <h2>Delete Product</h2>
        <form method="post">
            <label>Select Type:</label>
            <select name="type" id="type" onchange="toggleFormFields()">
                <option value="package">Package</option>
                <option value="hotel">Hotel</option>
            </select>

            <!-- Package Fields -->
            <div id="package_fields">
                <label>Package Name:</label>
                <input type="text" name="package_name">
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
            </div>

            <button type="submit">Delete</button>
        </form>
    </div>
<?php endif; ?>

<script>
function toggleFormFields() {
    var type = document.getElementById("type").value;

    // Show fields based on selected type
    document.getElementById("package_fields").style.display = (type === "package") ? "block" : "none";
    document.getElementById("hotel_fields").style.display = (type === "hotel") ? "block" : "none";
}
</script>

</body>
</html>
