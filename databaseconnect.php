<?php
// Database connection details (replace with your actual credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contactus";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if($_SERVER['REQUEST_METHOD']=='POST'){
    $sname = $_POST['sname'];
    $scontact = $_POST['scontact'];
    $semail = $_POST['semail'];
    $sreason = $_POST['sreason'];

    // Validate contact number
    if(!preg_match('/^\d{10}$/', $scontact)) {
        echo "Error: Invalid contact number format. Please enter a 10-digit number.";
        exit();
        
    }

 if(isset($_POST['submit'])){

 

    // Insert data into the database
    $sql = "INSERT INTO Contact (sname,scontact,semailid ,sreason) VALUES ('$sname', '$scontact', '$semail', '$sreason')";
    if(mysqli_query($conn, $sql)) {
        echo "Record Inserted";   } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
 } mysqli_close($conn);
?>