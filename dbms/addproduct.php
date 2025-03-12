<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "healthhaven"; // Replace with your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$category = $_POST['category'];
$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];
$image_url = $_POST['image_url'];

// Escape the URL and other inputs
$image_url = mysqli_real_escape_string($conn, $image_url);
$name = mysqli_real_escape_string($conn, $name);
$description = mysqli_real_escape_string($conn, $description);
$price = mysqli_real_escape_string($conn, $price);

// Determine the table based on the selected category
switch ($category) {
    case "beauty":
        $table = "beauty";
        break;
    case "babycare":
        $table = "babycare";
        break;
    case "supplements":
        $table = "supplements";
        break;
    case "devices":
        $table = "devices";
        break;
    case "ayurveda":
        $table = "ayurveda";
        break;
    case "basic":
        $table = "basic";
        break;
    default:
        die("Invalid category selected.");
}

// Prepare the SQL query to insert the data into the correct table
$sql = "INSERT INTO $table (name, info, price, url) 
        VALUES ('$name', '$description', '$price', '$image_url')";

// Execute the query and check for success
if ($conn->query($sql) === TRUE) {
    echo "<h1>Product added successfully to the $category category!</h1>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Added</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            margin: 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<h2>What would you like to do next?</h2>

<!-- Button to go back to the add product page -->
<button onclick="window.location.href='admin.html';">Add Another Product</button>

<!-- Button to go to the main website -->
<button onclick="window.location.href='new.html';">Go to Website</button>

</body>
</html>
