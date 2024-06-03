<?php
// Place this code at the start of your PHP file to handle sessions and user authentication
session_start();

// Check if the admin is logged in, redirect to login if not
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php"); // Redirect to your admin login page
    exit();
}

// Include your database connection file
include "connection.php"; // Update this with your database connection script

// Perform the SQL query to retrieve merged information
$sql = "SELECT
user.first_name,
donor.age,
donor.medical_condition,
donor.blood_group,
donates_in.unit,
blood_bank.Blood_bank_name
FROM
user 
INNER JOIN
donor  ON user.user_id = donor.D_user_id
INNER JOIN
donates_in ON donor.D_user_id = donates_in.user_id
INNER JOIN
blood_bank ON donates_in.blood_bank_id = blood_bank.blood_bank_id";

$result = $conn->query($sql); // Execute the query
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donor List</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Add your CSS styles or link CSS files here -->
    <style>
        /* Example CSS styles */
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Navbar styling */
        .navbar {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 15px 0;
        }
        .navbar a {
            color: #fff;
            text-decoration: none;
            margin: 0 20px;
            transition: color 0.3s ease;
        }
        .navbar a:hover {
            color: #ffd700; /* Change color on hover */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .welcome-message {
          font-size: 3em;
          text-align: center;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <!-- Your navbar containing buttons like search blood, profile, History, my order, donation, and report -->
        <i class='bx bx-user'></i><?php echo $_SESSION['name'] ; ?>
        <a href="admin_home.php">Home</a>
        <a href="logout.php">Log Out <i class='bx bx-log-out'></i></a>
        <!-- Add necessary links to these buttons -->
    </div>
    <div class="welcome-message">
    Welcome Admin!
    </div>
    <h2>Donor Information</h2>
    <table>
        <thead>
            <tr>
                <th>First Name</th>
                <th>Age</th>
                <th>Medical Condition</th>
                <th>Blood Group</th>
                <th>Unit</th>
                <th>Blood Bank Name</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['first_name'] . "</td>";
                    echo "<td>" . $row['age'] . "</td>";
                    echo "<td>" . $row['medical_condition'] . "</td>";
                    echo "<td>" . $row['blood_group'] . "</td>";
                    echo "<td>" . $row['unit'] . "</td>";
                    echo "<td>" . $row['Blood_bank_name'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No donor information available</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>