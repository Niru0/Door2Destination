<?php
session_start(); // Start the session

// Check if the user is already authenticated
if(isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    // Redirect to some authenticated page if needed
    header("Location: authenticated_page.php");
    exit;
}

$errors = array(); // Array to store validation errors

// Server-side form validation and processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validation functions
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
        $errors["email"] = "Email is required.";
    }

    // Validate rating
    if (!isset($_POST["rating"]) || !validateRating($_POST["rating"])) {
        $errors["rating"] = "Rating is required.";
    }

    // Validate feedback
    if (!validateFeedback($_POST["feedback"])) {
        $errors["feedback"] = "Feedback is required.";
    }

    // If there are no validation errors, process the form
    if (empty($errors)) {
        // Authentication (dummy check, replace with your actual authentication logic)
        if ($_POST["name"] === "admin" && $_POST["email"] === "admin@example.com") {
            // Set session variables upon successful authentication
            $_SESSION['authenticated'] = true;
            $_SESSION['username'] = $_POST["name"];
        } else {
            $errors["authentication"] = "Invalid credentials.";
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
        /* Your CSS styles here */
    </style>
</head>
<body>
    <?php if(isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true): ?>
        <!-- Authenticated content -->
        <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <!-- Login form -->
        <div class="container">
            <h2>Login</h2>
            <?php if(isset($errors["authentication"])) { echo "<span class='error'>" . $errors["authentication"] . "</span>"; } ?>
            <form id="loginForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <input type="text" name="name" id="name" placeholder="Your Name">
                <input type="email" name="email" id="email" placeholder="Your Email">
                <button type="submit">Login</button>
            </form>
        </div>
    <?php endif; ?>
</body>
</html>
