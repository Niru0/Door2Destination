<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // If not logged in, redirect to login page
    header("Location: login.php");
    exit;
}

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "bookings";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $hotel = mysqli_real_escape_string($conn, $_POST['hotel']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $checkin = mysqli_real_escape_string($conn, $_POST['checkin']);
    $checkout = mysqli_real_escape_string($conn, $_POST['checkout']);
    $rooms = mysqli_real_escape_string($conn, $_POST['rooms']);
    $guests = mysqli_real_escape_string($conn, $_POST['guests']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    // Insert data into the database
    $sql = "INSERT INTO bookings (hotel, name, email, checkin, checkout, rooms, guests, message)
            VALUES ('$hotel', '$name', '$email', '$checkin', '$checkout', '$rooms', '$guests', '$message')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Booking successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking</title>
    <style>
        /* CSS Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="email"],
        input[type="datetime-local"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Hotel Booking</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="hotel">Select Hotel:</label>
            <select id="hotel" name="hotel" required>
                <option value="" disabled selected>Select Hotel</option>
                <option value="hotel1">Far East Village Hotel</option>
                <option value="hotel2">Grand Nikko</option>
                <option value="hotel3">Hotel Granvia</option>
                <option value="hotel4">Swissotel</option>
                <option value="hotel5">APA Hotel</option>
                <option value="hotel6">Solaria Hotel</option>                
            </select>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="checkin">Check-in Date/Time:</label>
            <input type="datetime-local" id="checkin" name="checkin" required>
            <label for="checkout">Check-out Date/Time:</label>
            <input type="datetime-local" id="checkout" name="checkout" required>
            <label for="rooms">Number of Rooms:</label>
            <input type="number" id="rooms" name="rooms" min="1" required>
            <label for="guests">Number of Guests:</label>
            <input type="number" id="guests" name="guests" min="1" required>
            <label for="message">Additional Requests:</label>
            <textarea id="message" name="message" rows="4"></textarea>
            <input type="submit" value="Book Now">
        </form>
        <p>Contact us at <a href="tel:+1234567890">123-456-7890</a> or <a href="mailto:info@example.com">info@example.com</a> for assistance.</p>
    </div>
</body>
</html>
