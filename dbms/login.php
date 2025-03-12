<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Sanitize input to prevent SQL injection
    $email = $conn->real_escape_string($email);

    // Query to get user
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found
        $user = $result->fetch_assoc();
        
        // Verify password (assuming passwords are hashed)
        if (password_verify($password, $user['password'])) {
            // Successful login
            echo "Login successful! Welcome " . $user['email'];
            
            // Redirect to main homepage
            header("Location: index.html");
            exit();
        } else {
            // Incorrect password
            echo "Invalid email or password.";
        }
    } else {
        // User not found
        echo "Invalid email or password.";
    }
}

// Close the database connection
$conn->close();
?>

