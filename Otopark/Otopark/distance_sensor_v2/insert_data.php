<?php
$servername = "localhost";
$username = "root";  // MySQL kullanıcı adı
$password = "";  // MySQL şifresi
$dbname = "park_database";    // Veritabanı adı

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from the GET request
if (isset($_GET['spot_name']) && isset($_GET['distance']) && isset($_GET['is_parked'])) {
    $spot_name = $_GET['spot_name'];
    $distance = $_GET['distance'];
    $isParked = $_GET['is_parked'];

    // Insert data into MySQL database
    $sql = "INSERT INTO parking_data (spot_name, distance, is_parked) VALUES ('$spot_name', '$distance', '$isParked')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Data not received!";
}

$conn->close();
?>
