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


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 
    $name = $conn->real_escape_string($_POST['name']);
    $pno = $conn->real_escape_string($_POST['pno']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $confirmPassword = $conn->real_escape_string($_POST['confirm_password']);

    // Check if the email already exists
    $sqlCheck = "SELECT * FROM users WHERE email = '$email'";
    $resultCheck = $conn->query($sqlCheck);

    if ($resultCheck->num_rows > 0) {
        // Email already exists
        echo "Email is already registered. Please use a different email.";
    } else {
        // Check if passwords match
        if ($password === $confirmPassword) {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            
            $sqlInsert = "INSERT INTO users (name,email, password,phone) VALUES ('$name','$email', '$hashedPassword','$pno')";

            if ($conn->query($sqlInsert) === TRUE) {
                // Registration successful
                echo "Registration successful! You can now login.";
                header("Location: index.html"); // Redirect to homepage
                exit();
            } else{
                echo "Error: " . $sqlInsert . "<br>" . $conn->error;
            }
        } else {
            // Passwords do not match
            echo "Passwords do not match. Please try again.";
        }
    }
}

$conn->close();
?>

