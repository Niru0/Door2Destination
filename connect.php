<?php
// Database connection details (replace with your actual credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "database123";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if(isset($_POST['submit'])){
    $Country = $_POST['Country'];
    $Location = $_POST['Location'];
    $Name = $_POST['Name'];
    $Contact = $_POST['Contact'];

    // Validate contact number format
    if(!preg_match('/^\d{10}$/', $Contact)) {
        echo "Error: Invalid contact number format. Please enter a 10-digit number.";
        exit();
    }

    // Hash the contact number
    $hashedContact = password_hash($Contact, PASSWORD_DEFAULT);

    // Insert data into the database
    $sql = "INSERT INTO v1 (Country, Location, Name, Contact) VALUES ('$Country', '$Location', '$Name', '$hashedContact')";
    if(mysqli_query($conn, $sql)) {
        echo "Record Inserted";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
