<?php
// Database connection details (replace with your actual credentials)
$server_name = "localhost";
$username = "root";
$password = "";
$database_name = "contactus";

// Create connection
$conn = mysqli_connect($server_name, $username, $password, $database_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $reason = $_POST['reason'];
    
    // Hash the email using bcrypt
    $hashed_email = password_hash($email, PASSWORD_BCRYPT);

    // Insert data into the database
    $sql_query = "INSERT INTO contact (name, phone, email, reason) 
                  VALUES ('$name', '$phone', '$hashed_email', '$reason')";

    if (mysqli_query($conn, $sql_query)) {
        echo "Record Inserted";
    } else {
        echo "Error: " . $sql_query . "<br>" . mysqli_error($conn);
    }
    
    mysqli_close($conn);
}
?>
