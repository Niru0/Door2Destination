<?php
// Start PHP session (if needed)
session_start();

// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Check database for user
    if (empty($email_err) && empty($password_err)) {
        // Database connection
        $servername = "localhost";
        $username = "root";
        $db_password = "";
        $dbname = "sdb";

        $conn = new mysqli($servername, $username, $db_password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and execute query
        $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            // Store user data in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            
            // Redirect to welcome page
            header("Location: navbar.html");
            exit();
        } else {
            echo "<p>Invalid email or password</p>";
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

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="./style.css">
    <style>
        body {
            background-image: url('jacek-dylag-SPpsFbCaN2A-unsplash.jpg'); 
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif; 
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-box {
            background-color: rgba(255, 255, 255, 0.8); 
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .login-box h1 {
            margin-bottom: 20px;
        }

        .login-box input[type="email"],
        .login-box input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        .login-box input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            border: none;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .login-box input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            font-size: 14px;
        }

        .compulsory {
            color: red;
        }

        /* Add any additional styling here */
    </style>
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h1>Login</h1>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label>Email<span class="compulsory">*</span></label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <span class="error"><?php echo $email_err; ?></span>
                <br>
                <br>
                <label>Password<span class="compulsory">*</span></label>
                <input type="password" name="password" value="<?php echo htmlspecialchars($password); ?>">
                <span class="error"><?php echo $password_err; ?></span>

                <input type="submit" value="Login">
            </form>
            <p style="text-align: center; margin-top: 20px;">Don't have an account? <a href="signup.php">Sign Up</a></p>

        </div>
    </div>
</body>
</html>
