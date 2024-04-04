<?php
session_start(); // Start the session

// Check if the feedback name is set in the session
if (isset($_SESSION['feedback_name'])) {
    $feedback_name = $_SESSION['feedback_name'];
} else {
    $feedback_name = "Anonymous"; // Default value if the name is not set
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
        }
        h2 {
            color: #007bff;
            margin-bottom: 20px;
        }
        p {
            color: #333;
            font-size: 18px;
            line-height: 1.5;
            margin-bottom: 30px;
        }
        .button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Thank You, <?php echo $feedback_name; ?>!</h2>
        <p>Your feedback has been successfully submitted.</p>
        <a href="feedback.php" class="button">Leave Another Feedback</a>
        <a href="save.php">REVIEWS</a>
    </div>
</body>
</html>

