<?php
// Database configuration
$servername = "localhost"; // Change this to your MySQL server hostname if it's different
$username = "your_username"; // Change this to your MySQL username
$password = "your_password"; // Change this to your MySQL password
$dbname = "volunteer_enrollment"; // Change this to the desired name of your database

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error;
}

// Select database
$conn->select_db($dbname);

// SQL to create table
$sql = "CREATE TABLE IF NOT EXISTS volunteers (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    country VARCHAR(50) NOT NULL,
    location VARCHAR(100) NOT NULL,
    name VARCHAR(100) NOT NULL,
    serve ENUM('yes', 'no') NOT NULL,
    submission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

// Execute query
if ($conn->query($sql) === TRUE) {
    echo "Table volunteers created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error;
}

// Close connection
$conn->close();
?>
