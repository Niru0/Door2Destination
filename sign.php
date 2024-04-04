<?php
// Start PHP session (if needed)
session_start();

// Define variables and initialize with empty values
$first_name = $last_name = $email = $password = "";
$first_name_err = $last_name_err = $email_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate first name
    if (empty($_POST["first_name"])) {
        $first_name_err = "First name is required";
    } else {
        $first_name = test_input($_POST["first_name"]);
    }

    // Validate last name
    if (empty($_POST["last_name"])) {
        $last_name_err = "Last name is required";
    } else {
        $last_name = test_input($_POST["last_name"]);
    }

    // Validate email
    if (empty($_POST["email"])) {
        $email_err = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
    }

    // Validate password
    if (empty($_POST["password"])) {
        $password_err = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
    }

    // If all fields are validated, proceed with database insertion
    if (empty($first_name_err) && empty($last_name_err) && empty($email_err) && empty($password_err)) {
        // Database connection
        $servername = "localhost";
        $username = "root";
        $db_password = "";
        $dbname = "sdb";

        $conn = new mysqli($servername, $username, $db_password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if email already exists
        $stmt_check_email = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt_check_email->bind_param("s", $email);
        $stmt_check_email->execute();
        $stmt_check_email->store_result();

        if ($stmt_check_email->num_rows > 0) {
            $email_err = "Email already exists";
        } else {
            // Insert new user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt_insert_user = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
            $stmt_insert_user->bind_param("ssss", $first_name, $last_name, $email, $hashed_password);

            if ($stmt_insert_user->execute()) {
                echo "<p>Registration successful. You can now log in.</p>";
            } else {
                echo "Error: " . $stmt_insert_user->error;
            }

            $stmt_insert_user->close();
        }

        $stmt_check_email->close();
        $conn->close();
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
    <title>Sign Up</title>
    <link rel="stylesheet" href="./style.css">
    <style>
        body {
            background-image: url('jacek-dylag-SPpsFbCaN2A-unsplash.jpg'); /* Specify the path to your background image */
            background-size: cover; /* Cover the entire background */
            background-repeat: no-repeat; /* Do not repeat the background image */
            font-family: Arial, sans-serif; /* Use Arial or sans-serif font */
            margin: 0; /* Remove default margin */
            padding: 0; /* Remove default padding */
            display: flex; /* Use flexbox to center content */
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            height: 100vh; /* Full height of the viewport */
        }

        .signup-box {
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Shadow effect */
            text-align: center;
            max-width: 400px; /* Set maximum width for the form */
            width: 100%; /* Make sure form takes full width within its container */
        }

        .signup-box h1 {
            margin-top: 0;
        }

        .signup-box input[type="text"],
        .signup-box input[type="email"],
        .signup-box input[type="password"] {
            width: calc(100% - 20px); /* Subtract padding from width */
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box; /* Include padding and border in width calculation */
        }

        .signup-box input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .signup-box input[type="submit"]:hover {
            background-color: #45a049;
        }

        .signup-box p {
            margin-bottom: 20px;
        }

        .signup-box a {
            color: #4CAF50;
        }

        .error {
            color: red;
        }

        .signup-box label::after {
            content: "*"; /* Add asterisk after label */
            color: red;
        }
    </style>
</head>
<body>
    <div class="signup-box">
        <h1>Sign Up</h1><br>
        <h4>It's free and only takes a minute</h4>
        <br>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label>First Name:</label>
            <input type="text" name="first_name" value="<?php echo $first_name; ?>">
            <span class="error"><?php echo $first_name_err; ?></span>
            <br>
            <br>
            <label>Last Name:</label>
            <input type="text" name="last_name" value="<?php echo $last_name; ?>">
            <span class="error"><?php echo $last_name_err; ?></span>
            <br>
            <br>
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $email; ?>">
            <span class="error"><?php echo $email_err; ?></span>
            <br>
            <br>
            <label>Password:</label>
            <input type="password" name="password" value="<?php echo $password; ?>">
            <span class="error"><?php echo $password_err; ?></span>
            <br>
            <br>
            <input type="submit" value="Sign Up">
        </form>
        <br>
        <p>By clicking the sign up button, you agree to our<br>
        <a href="#">terms and condition</a> and <a href="#">Policy Privacy</a></p>
        <p class="para-2">Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
