<?php

// Define variables and initialize with empty values
$nameErr = $contactErr = $emailErr = $reasonErr = "";
$name = $contact = $email = $reason = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
        // Check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
            $nameErr = "Only letters and white space allowed";
        }
    }

    // Validate contact number
    if (empty($_POST["contact"])) {
        $contactErr = "Contact number is required";
    } else {
        $contact = test_input($_POST["contact"]);
        // Check if contact number is valid
        if (!preg_match("/^[0-9]*$/",$contact)) {
            $contactErr = "Invalid contact number";
        }
    }

    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        // Check if email address is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    // Validate reason
    if ($_POST["reason"] == "slct") {
        $reasonErr = "Please select a reason";
    } else {
        $reason = test_input($_POST["reason"]);
    }

    // If all fields are filled and valid, process the form
    if (empty($nameErr) && empty($contactErr) && empty($emailErr) && empty($reasonErr)) {
        // Process the form (e.g., store data in database)
        // Redirect or display success message
        echo "Form submitted successfully!";
    }
}

// Function to sanitize and validate input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <form action="#" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">

        <h3>Contact</h3>
        <p><label for="name">Name</label></p>
        <input type="text" id="sname" name="name">
        <span id="nameError" class="error"><?php echo $nameErr;?></span>

        <p><label for="phone">Contact Number</label></p>
        <input type="text" id="scontact" name="phone">
        <span id="contactError" class="error"><?php echo $contactErr;?></span>

        <p><label for="email">Email ID</label></p>
        <input type="email" id="semail" name="email">
        <span id="emailError" class="error"><?php echo $emailErr;?></span>

        <p><label for="reason">Reason</label></p>
        <select id="reason" name="reason">
            <option value="Room Availability">Room Availability</option>
            <option value="slct" selected>Select</option>
            <option value="Room Facilities">Room Facilities</option>
            <option value="Room Charges">Room Charges</option>
            <option value="Book Room">Book Room</option>
         </select>
         <span id="reasonError" class="error"><?php echo $reasonErr;?></span>
         
         <pre><br></pre>
         <input type="submit" value="Submit" name="save">
    </form> 
</body>
</html>
