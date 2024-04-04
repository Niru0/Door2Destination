<?php
session_start(); // Start the session

// Define database connection credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "sdb";

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Define variables and initialize with empty values
    $userFirstName = $userLastName = $userEmail = $userPassword = "";
    $errors = array();

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate first name
        $userFirstName = test_input($_POST["firstName"]);
        if (empty($userFirstName)) {
            $errors[] = "First name is required";
        }

        // Validate last name
        $userLastName = test_input($_POST["lastName"]);
        if (empty($userLastName)) {
            $errors[] = "Last name is required";
        }

        // Validate email
        $userEmail = test_input($_POST["email"]);
        if (empty($userEmail)) {
            $errors[] = "Email is required";
        } elseif (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        } else {
            // Check if email already exists in the database
            $sql_check_email = "SELECT id FROM users WHERE email = ?";
            $stmt_check_email = $conn->prepare($sql_check_email);
            $stmt_check_email->bind_param("s", $userEmail);
            $stmt_check_email->execute();
            $result_check_email = $stmt_check_email->get_result();
            if ($result_check_email->num_rows > 0) {
                $errors[] = "Email address is already registered";
            }
            $stmt_check_email->close();
        }

        // Validate password
        $userPassword = test_input($_POST["password"]);
        if (empty($userPassword)) {
            $errors[] = "Password is required";
        }

        // If there are no validation errors, insert data into database
        if (empty($errors)) {
            // Hash the password
            $hashed_password = password_hash($userPassword, PASSWORD_BCRYPT);

            // Prepare SQL statement to insert data
            $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $userFirstName, $userLastName, $userEmail, $hashed_password);

            // Execute the prepared statement
            if ($stmt->execute()) {
                // Store first name in session
                $_SESSION['firstName'] = $userFirstName;
                // Redirect to welcome page
                header("Location: welcome.php");
                exit();
            } else {
                throw new Exception("Error: " . $sql . "<br>" . $conn->error);
            }

            // Close statement
            $stmt->close();
        } else {
            // If there are validation errors, display them
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
        }
    }
} catch (Exception $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
}

// Helper function to sanitize input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Close connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <div class="signup-box">
        <h1> Sign Up </h1>
        <h4>It's free and only takes a minute </h4>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label>First Name</label>
            <input type="text" name="firstName" value="<?php echo $userFirstName; ?>" required>
            <label>Last Name</label>
            <input type="text" name="lastName" value="<?php echo $userLastName; ?>" required>
            <label>Email</label>
            <input type="email" name="email" value="<?php echo $userEmail; ?>" required>
            <label>Password</label>
            <input type="password" name="password" required>
            <input type="submit" value="Submit">
        </form>
        <p>By clicking the sign up button, you agree to our <br>
        <a href="#">terms and conditions</a> and <a href="#">Privacy Policy</a>
        </p>
    </div>
    <p class="para-2">Already have an account? <a href="login.html">Login here</a></p>
</body>
</html>
