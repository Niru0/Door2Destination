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

        select, input[type="text"], input[type="tel"], input[type="radio"], input[type="checkbox"] {
            width: calc(100% - 22px); 
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
            display: inline; 
        }
    </style>
</head>
<body>
    <form name="f" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h1>Volunteer Enrollment Form</h1>
        <label for="country">Select Country:</label>
        <select  name="Country" id="country" required >
            <option value="" disabled selected>Select Country</option>
            <option value="India">India</option>
            <option value="USA">USA</option>
            <!-- Add more options as needed -->
        </select><span class="required-star">*</span><br>
        <?php if(isset($errors['Country'])) echo '<span class="error-message">' . $errors['Country'] . '</span>'; ?>
        
        <label for="location">Enter Location:</label>
        <input type="text" name="Location" id="location" pattern="[A-Za-z\s]+" title="Please enter letters and spaces only." required>
        <span class="required-star">*</span>
        <?php if(isset($errors['Location'])) echo '<span class="error-message">' . $errors['Location'] . '</span>'; ?><br>
        
        <label for="name">Enter Name:</label>
        <input type="text" name="Name" id="name" pattern="[A-Za-z\s]+" title="Please enter letters and spaces only." required>
        <span class="required-star">*</span>
        <?php if(isset($errors['Name'])) echo '<span class="error-message">' . $errors['Name'] . '</span>'; ?><br>
        
        <label for="contact">Enter Contact Number:</label>
        <input type="tel" name="Contact" id="contact" pattern="\d{10}" title="Please enter a 10-digit number." required>
        <span class="required-star">*</span>
        <?php if(isset($errors['Contact'])) echo '<span class="error-message">' . $errors['Contact'] . '</span>'; ?><br>
        
        <label for="serve">Are you interested to serve as a Volunteer?</label>
        <input type="radio" id="yes1" name="serve" value="yes" required>
        <label for="yes1">Yes</label>
        <input type="radio" id="no1" name="serve" value="no" required>
        <label for="no1">No</label>
        <span class="required-star">*</span><br>
        <?php if(isset($errors['serve'])) echo '<span class="error-message">' . $errors['serve'] . '</span>'; ?><br>
        
        <label><input type="checkbox" name="cb" required> Confirm your submission</label>
        <span class="required-star">*</span><br>
        <?php if(isset($errors['cb'])) echo '<span class="error-message">' . $errors['cb'] . '</span>'; ?><br>
        
        <input type="submit" value="Submit" name="submit">
    </form>
    
    <?php
    
    $errors = array();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $country = $_POST['Country'];
        $location = $_POST['Location'];
        $name = $_POST['Name'];
        $contact = $_POST['Contact'];
        $serve = isset($_POST['serve']) ? $_POST['serve'] : '';
        $confirmSubmission = isset($_POST['cb']) ? $_POST['cb'] : '';

        if (empty($country) || $country == "Select Country") {
            $errors['Country'] = 'Please select a country.';
        }

        if (empty($location)) {
            $errors['Location'] = 'Please enter a location.';
        }

        if (empty($name)) {
            $errors['Name'] = 'Please enter your name.';
        }

        if (!preg_match("/^\d{10}$/", $contact)) {
            $errors['Contact'] = 'Please enter a valid 10-digit contact number.';
        }

        if (empty($serve)) {
            $errors['serve'] = 'Please select if you are interested to serve as a volunteer.';
        }

        if (empty($confirmSubmission)) {
            $errors['cb'] = 'Please confirm your submission.';
        }

        if (empty($errors)) {
           
            echo '<script>alert("Form Successfully Submitted");</script>';
           
        }
    }
    ?>
</body>
</html>
