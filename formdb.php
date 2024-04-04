<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define variables and initialize with empty values
    $name = $contact = $email = $reason = "";

    // Initialize database connection parameters
    $servername = "localhost";
    $username = "your_username";
    $password = "your_password";
    $dbname = "your_database_name";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare data for database insertion
    $name = test_input($_POST["name"]);
    $contact = test_input($_POST["contact"]);
    $email = test_input($_POST["em"]);
    $reason = test_input($_POST["rsn"]);

    // SQL statement to insert data into the database
    $sql = "INSERT INTO your_table_name (name, contact, email, reason) VALUES ('$name', '$contact', '$email', '$reason')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close database connection
    $conn->close();
}

// Function to sanitize and validate input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
