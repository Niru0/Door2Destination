<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Enrollment Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        form {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        select, input[type="text"], input[type="radio"], input[type="checkbox"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="radio"], input[type="checkbox"] {
            width: auto;
        }

        label {
            display: inline-block; 
            margin-bottom: 5px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .required-star {
            color: red;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <form name="f" method="post" action="2.php"<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h1>Volunteer Enrollment Form</h1>
        <label for="country">Select Country:</label>
        <select name="country" id="country" required>
            <option value="" disabled selected>Select Country</option>
            <option value="India">India</option>
            <option value="USA">USA</option>
            <!-- Add more options as needed -->
        </select><span class="required-star">*</span><br>
        <label for="location">Enter Location:</label>
        <input type="text" name="location" id="location" required>
        <span class="required-star">*</span>
        <span class="error-message"><?php echo $locationErr ?? ''; ?></span><br>
        <label for="name">Enter Name:</label>
        <input type="text" name="name" id="name" required>
        <span class="required-star">*</span>
        <span class="error-message"><?php echo $nameErr ?? ''; ?></span><br>
        <label for="serve">Are you interested to serve as a Volunteer?</label>
        <input type="radio" id="yes1" name="serve" value="yes" required>
        <label for="yes1">Yes</label>
        <input type="radio" id="no1" name="serve" value="no" required>
        <label for="no1">No</label>
        <span class="required-star">*</span>
        <span class="error-message"><?php echo $serveErr ?? ''; ?></span><br>

        <label><input type="checkbox" name="cb" required> Confirm your submission</label><span class="required-star">*</span><br>
        <input type="submit" value="Submit">
        <center>
            <audio src="au.wav" controls="play"></audio>
        </center>
    </form>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $country = $_POST["country"];
            $location = $_POST["location"];
            $name = $_POST["name"];
            $serve = $_POST["serve"];
            $cb = $_POST["cb"];

            // Check if all required fields are filled
            if (empty($country) || $country === "Select Country" || empty($location) || empty($name) || empty($cb)) {
                echo '<script>alert("Please fill out all required fields and confirm your submission.");</script>';
            } else {
                // Validate name field
                if (!preg_match("/^[A-Za-z]+$/", $name)) {
                    $nameErr = "Name must contain only alphabets.";
                }

                // Validate location field
                if (!preg_match("/^[A-Za-z\s]+$/", $location)) {
                    $locationErr = "Location can only contain letters and spaces.";
                }

                // Validate serve as a volunteer selection
                if (empty($serve)) {
                    $serveErr = "Please select an option.";
                }

                // Success message
                if (empty($nameErr) && empty($locationErr) && empty($serveErr)) {
                    echo '<script>alert("Form Successfully Submitted");</script>';
                    // Optionally, you can submit the form asynchronously using AJAX instead of reloading the page
                    // Example: submitFormAsync();
                }
            }
        }
    ?>
  
</body>
</html>
