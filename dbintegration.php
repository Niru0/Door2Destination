<!DOCTYPE html>
<html>
<head>
    <title>Contact Us Entries</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Contact Us Entries</h2>

<table>
    <tr>
        <th>Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Reason</th>
    </tr>

<?php
// Database connection details (replace with your actual credentials)
$server_name = "localhost";
$username = "root";
$password = "";
$database_name = "contactus";

// Create connection
$conn = mysqli_connect($server_name, $username, $password, $database_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve data from the database
$sql_query = "SELECT name, phone, email, reason FROM contact";
$result = mysqli_query($conn, $sql_query);

if (mysqli_num_rows($result) > 0) {
    // Output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>".$row["name"]."</td>";
        echo "<td>".$row["phone"]."</td>";
        // Since email is hashed, you might not want to display it directly
        echo "<td>Hidden</td>";
        echo "<td>".$row["reason"]."</td>";
        echo "</tr>";
    }
} else {
    echo "0 results";
}

mysqli_close($conn);
?>

</table>

</body>
</html>
