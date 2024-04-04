<?php
session_start(); // Start the session

$errors = array(); // Array to store validation errors

// Server-side form validation and processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validation functions (same as before)
    function validateName($name) {
        return isset($name) && strlen(trim($name)) > 0;
    }

    function validateEmail($email) {
        return isset($email) && filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function validateRating($rating) {
        return isset($rating) && $rating !== '';
    }

    function validateFeedback($feedback) {
        return isset($feedback) && strlen(trim($feedback)) > 0;
    }

    // Validate name
    if (!validateName($_POST["name"])) {
        $errors["name"] = "Name is required.";
    }

    // Validate email
    if (!validateEmail($_POST["email"])) {
        $errors["email"] = "Valid email is required.";
    }

    // Validate rating
    if (!validateRating($_POST["rating"])) {
        $errors["rating"] = "Rating is required.";
    }

    // Validate feedback
    if (!validateFeedback($_POST["feedback"])) {
        $errors["feedback"] = "Feedback is required.";
    }

    // If there are no validation errors, process the form
    if (empty($errors)) {
        // Database connection parameters
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "feedback";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare SQL statement for insertion
        $stmt = $conn->prepare("INSERT INTO feedback (hashed_name, email, rating, feedback) VALUES (?, ?, ?, ?)");

        // Bind parameters
        $stmt->bind_param("ssis", $hashed_name, $email, $rating, $feedback);

        // Set parameters and execute statement
        $name = $_POST["name"];
        $hashed_name = password_hash($name, PASSWORD_DEFAULT); // Hash the name
        $email = $_POST["email"];
        $rating = intval($_POST["rating"]);
        $feedback = $_POST["feedback"];

        if ($stmt->execute()) {
            // Set the feedback name in a session variable
            $_SESSION['feedback_name'] = $name;

            // Redirect to the "Thank You" page
            header("Location: thank_you.php");
            exit;
        } else {
            echo "<h2>Error submitting feedback. Please try again later.</h2>";
        }

        // Close statement
        $stmt->close();

        // Close connection
        $conn->close();
    } else {
        // Display validation errors
        echo "<h2>Validation Errors:</h2>";
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input,
        select,
        textarea {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Feedback Form</h2>
        <form id="feedbackForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="text" name="name" id="name" placeholder="Your Name">
            <?php if(isset($errors["name"])) { echo "<span class='error'>" . $errors["name"] . "</span>"; } ?>
            <input type="email" name="email" id="email" placeholder="Your Email">
            <?php if(isset($errors["email"])) { echo "<span class='error'>" . $errors["email"] . "</span>"; } ?>
            <select name="rating" id="rating">
                <option value="" disabled selected>Select Rating</option>
                <option value="1">1 Star</option>
                <option value="2">2 Stars</option>
                <option value="3">3 Stars</option>
                <option value="4">4 Stars</option>
                <option value="5">5 Stars</option>
            </select>
            <?php if(isset($errors["rating"])) { echo "<span class='error'>" . $errors["rating"] . "</span>"; } ?>
            <textarea name="feedback" id="feedback" placeholder="Your Feedback"></textarea>
            <?php if(isset($errors["feedback"])) { echo "<span class='error'>" . $errors["feedback"] . "</span>"; } ?>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
