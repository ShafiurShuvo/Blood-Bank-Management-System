<?php
session_start();
// Check if the admin is logged in, redirect to login if not
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php"); // Redirect to your admin login page
    exit();
}
include "connection.php"; 
// Perform the SQL query to retrieve merged information
$sql = "SELECT user.first_name, user.last_name, user.phone_number, user.email, patient.medicine_list, patient.doctor_advices, patient.P_hospital_id
FROM patient 
JOIN user  ON patient.P_user_id = user.user_id";

$result = $conn->query($sql); // Execute the query
?>


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
        <a href="admin_home.php">Profile</a>
        <!-- <a href="search_blood.php">Search Blood</a> <a href="#">History</a> -->
        <!-- <a href="#">My Order</a> --> 
        <!-- <a href="donor_page.php">Donate</a> -->
        <!-- <a href="feedback.php">Feedback</a> -->
        <a href="logout.php">Log Out <i class='bx bx-log-out'></i></a>
        <!-- Add necessary links to these buttons -->
        </div> 

    <div class="welcome-message">
    Welcome Admin!
    </div>
    <h2>Patient Information</h2>
    <table>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
  <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Medicine List</th>
                    <th>Doctor's Advices</th>
                    <th>Hospital ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Database connection
                include 'connection.php';

                // SQL query
                $sql = "SELECT u.first_name, u.last_name, u.phone_number, u.email, p.medicine_list, p.doctor_advices, p.P_hospital_id
                        FROM patient p
                        JOIN user u ON p.P_user_id = u.user_id";

                // Execute query
                $result = $conn->query($sql);

                // Display results
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
                        echo "<td>" . $row['phone_number'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['medicine_list'] . "</td>";
                        echo "<td>" . $row['doctor_advices'] . "</td>";
                        echo "<td>" . $row['P_hospital_id'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No patients found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>