<?php
// Database configuration
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$database = "hotels_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert sample data into 'users' table
$sql_users = "INSERT INTO users (username, password)
              VALUES ('john_doe', 'hashed_password_here'),
                     ('jane_smith', 'hashed_password_here')";
if ($conn->query($sql_users) === TRUE) {
    echo "Data inserted into 'users' table successfully<br>";
} else {
    echo "Error inserting data into 'users' table: " . $conn->error . "<br>";
}

// Insert sample data into 'hotels' table
$sql_hotels = "INSERT INTO hotels (hotel_name, hotel_address, rating)
               VALUES ('Hotel ABC', '123 Main St, City, Country', 4.5),
                      ('Hotel XYZ', '456 Elm St, City, Country', 3.8)";
if ($conn->query($sql_hotels) === TRUE) {
    echo "Data inserted into 'hotels' table successfully<br>";
} else {
    echo "Error inserting data into 'hotels' table: " . $conn->error . "<br>";
}

// Close connection
$conn->close();
?>
