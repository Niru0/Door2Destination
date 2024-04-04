<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
</head>
<body>
    <h1>Register</h1>
    <?php
        // Display error message (if any)
        if (isset($_GET['error'])) {
            echo "<p style='color: red;'>".$_GET['error']."</p>";
        }
    ?>
    <form action="register_process.php" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>