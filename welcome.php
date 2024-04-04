<?php
session_start(); // Resume the session

// Check if name is set in session
if(isset($_SESSION['name'])) {
    $name = $_SESSION['name'];
} else {
    // If name is not set, redirect back to the form page
    header("Location: contactus.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
    <h2>Welcome <?php echo $name; ?></h2>
    <p>This is your welcome page.</p>
</body>
</html>
