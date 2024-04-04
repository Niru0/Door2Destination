<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="./style.css">
    <style></style>
</head>
<body>
    <div class="signup-box">
        <h1>Sign Up</h1>
        <h4>It's free and only takes a minute</h4>

        <?php
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
                $password = "";
                $dbname = "sdb";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $hashed_password=password_hash('$password',PASSWORD_DEFAULT);
                // Prepare and bind the insertion query
                $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $first_name, $last_name, $email, $hashed_password);

                // Execute the query
                if ($stmt->execute()) {
                    echo "<p>Registration successful. You can now log in.</p>";
                } else {
                    echo "Error: " . $stmt->error;
                }

                $stmt->close();
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

        <form method="post" action="welcome.php">
            <label>First Name</label>
            <input type="text" name="first_name" value="<?php echo $first_name; ?>">
            <span class="error"><?php echo $first_name_err; ?></span>

            <label>Last Name</label>
            <input type="text" name="last_name" value="<?php echo $last_name; ?>">
            <span class="error"><?php echo $last_name_err; ?></span>

            <label>Email</label>
            <input type="email" name="email" value="<?php echo $email; ?>">
            <span class="error"><?php echo $email_err; ?></span>

            <label>Password</label>
            <input type="password" name="password" value="<?php echo $password; ?>">
            <span class="error"><?php echo $password_err; ?></span>

            <input type="submit" value="Submit">
        </form>
    </div>

    <p>By clicking the sign up button, you agree to our<br>
        <a href="#">terms and condition</a> and <a href="#">Policy Privacy</a>
    </p>

    <p class="para-2">Already have an account? <a href="login.html">Login here</a></p>
</body>
</html>
