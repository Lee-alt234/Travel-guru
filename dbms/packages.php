<?php

$servername = "localhost"; 
$username = "root";        
$password = "";           
$dbname = "holiday"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM packages";
$result = $conn->query($sql);

// Check if there are any packages
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Fetching the required details from the database
        $image = $row['main'];
        $description = $row['description'];
        $name = $row['name'];
       
        $cost = $row['cost'];
        ?>
        
        <!-- HTML Layout for each package -->
        <div class="package-box">
            <div class="package-image">
                <img src="<?php echo $image; ?>" alt="Package Image" class="package-img">
            </div>
            <div class="package-details">
                <h2><?php echo $name; ?></h2>
                <p class="description"><?php echo $description; ?></p>
                <p><strong>Total Cost: </strong>$<?php echo $cost; ?></p>
                <a href="pbookings.php?package_name=<?php echo urlencode($row['name']); ?>" class="btn-booking">Book Now</a>

            </div>
        </div>

        <?php
    }
} else {
    echo "No packages available.";
}

$conn->close();
?>

<!-- CSS Styling -->
<style>
/* Styling for the package layout */
.package-box {
    display: flex;
    justify-content: space-between;
    margin: 20px 0;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.package-image {
    flex: 1;
    max-width: 45%;
}

.package-img {
    width: 100%;
    height: auto;
    border-radius: 8px;
}

.package-details {
    flex: 2;
    margin-left: 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.package-details h2 {
    font-size: 2em;
    margin: 0 0 10px 0;
}

.package-details p {
    font-size: 1.2em;
    margin: 5px 0;
}

.btn-booking {
    padding: 10px 20px;
    background-color: #ff6600;
    color: #fff;
    font-size: 1.2em;
    text-decoration: none;
    text-align: center;
    border-radius: 5px;
    margin-top: 20px;
    width: fit-content;
}

.btn-booking:hover {
    background-color: #ff4500;
}
</style>
