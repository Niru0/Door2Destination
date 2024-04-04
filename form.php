<?php

// Define variables and initialize with empty values
$name = $contact = $email = $reason = "";
$nameErr = $contactErr = $emailErr = $reasonErr = "";

// Define variables to hold submitted values
$submittedName = $submittedContact = $submittedEmail = $submittedReason = "";

// Function to sanitize and validate input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

try {
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get submitted values
        $submittedName = $_POST["name"];
        $submittedContact = $_POST["phone"];
        $submittedEmail = $_POST["email"];
        $submittedReason = $_POST["reason"];

        // Validate name
        if (empty($submittedName)) {
            $nameErr = "Name is required";
        } else {
            $name = test_input($submittedName);
            // Check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
                $nameErr = "Only letters and white space allowed";
            }
        }

        // Validate contact number
        if (empty($submittedContact)) {
            $contactErr = "Contact number is required";
        } else {
            $contact = test_input($submittedContact);
            // Check if contact number is valid
            if (!preg_match("/^[0-9]*$/", $contact)) {
                $contactErr = "Invalid contact number";
            }
        }

        // Validate email
        if (empty($submittedEmail)) {
            $emailErr = "Email is required";
        } else {
            $email = test_input($submittedEmail);
            // Check if email address is valid
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }
        }

        // Validate reason
        if ($submittedReason == "slct") {
            $reasonErr = "Please select a reason";
        } else {
            $reason = test_input($submittedReason);
        }

        // If any errors occurred, throw an exception
        if (!empty($nameErr) || !empty($contactErr) || !empty($emailErr) || !empty($reasonErr)) {
            throw new Exception("Validation error");
        }

        // If all fields are filled and valid, process the form
        // Process the form (e.g., store data in database)
        // Database connection details (replace with your actual credentials)
        $server_name = "localhost";
        $username = "root";
        $password = "";
        $database_name = "contactus";

        // Create connection
        $conn = mysqli_connect($server_name, $username, $password, $database_name);

        // Check connection
        if (!$conn) {
            throw new Exception("Connection failed: " . mysqli_connect_error());
        }

        // Hash the email using bcrypt
        $hashed_email = password_hash($email, PASSWORD_BCRYPT);

        // Insert data into the database
        $sql_query = "INSERT INTO contact (name, phone, email, reason) 
                      VALUES ('$name', '$contact', '$hashed_email', '$reason')";

        if (mysqli_query($conn, $sql_query)) {
            echo "Record Inserted";
        } else {
            throw new Exception("Error: " . $sql_query . "<br>" . mysqli_error($conn));
        }

        mysqli_close($conn);
    }
} catch (Exception $e) {
    // Error occurred, do not proceed further
    // Display error message
    // echo $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h3 {
            margin-top: 0;
        }

        p {
            margin: 10px 0;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .error {
            color: red;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

    </style>
</head>
<body>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">

            <h3>Contact</h3>
            <p><label for="name">Name</label></p>
            <input type="text" id="sname" name="name" value="<?php echo htmlspecialchars($submittedName); ?>">
            <span id="nameError" class="error"><?php echo $nameErr;?></span>

            <p><label for="phone">Contact Number</label></p>
            <input type="text" id="scontact" name="phone" value="<?php echo htmlspecialchars($submittedContact); ?>">
            <span id="contactError" class="error"><?php echo $contactErr;?></span>

            <p><label for="email">Email ID</label></p>
            <input type="email" id="semail" name="email" value="<?php echo htmlspecialchars($submittedEmail); ?>">
            <span id="emailError" class="error"><?php echo $emailErr;?></span>

            <p><label for="reason">Reason</label></p>
            <select id="reason" name="reason">
                <option value="Room Availability" <?php if ($submittedReason == "Room Availability") echo "selected"; ?>>Room Availability</option>
                <option value="slct" <?php if ($submittedReason == "slct") echo "selected"; ?>>Select</option>
                <option value="Room Facilities" <?php if ($submittedReason == "Room Facilities") echo "selected"; ?>>Room Facilities</option>
                <option value="Room Charges" <?php if ($submittedReason == "Room Charges") echo "selected"; ?>>Room Charges</option>
                <option value="Book Room" <?php if ($submittedReason == "Book Room") echo "selected"; ?>>Book Room</option>
            </select>
            <span id="reasonError" class="error"><?php echo $reasonErr;?></span>
            
            <pre><br></pre>
            <input type="submit" value="Submit" name="save">
        </form> 
    </div>
</body>
</html>
