<?php
// Place this code at the start of your PHP file to handle sessions and user authentication
session_start();

// Check if the admin is logged in, redirect to login if not
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php"); // Redirect to your admin login page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blood Bank List with Blood Groups</title> 
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
        <a href="user_home.php">Profile</a>
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
    

    <h2>Blood Bank List with Blood Groups</h2>
    <table>
        <thead>
            <tr>
                <th>Blood Bank Name</th>
                <th>Location</th>
                <th>Contact</th>
                <th>Blood Groups Stored</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "connection.php";
            
            $sql = "SELECT blood_bank.Blood_bank_name, blood_bank.location, blood_bank.Blood_bank_contact, GROUP_CONCAT(DISTINCT donor.blood_group SEPARATOR ', ') AS blood_groups, donates_in.unit
                    FROM donates_in
                    INNER JOIN blood_bank ON donates_in.blood_bank_id = blood_bank.blood_bank_id
                    INNER JOIN donor ON donates_in.user_id = donor.D_user_id
                    GROUP BY blood_bank.Blood_bank_name, blood_bank.location, blood_bank.Blood_bank_contact";
            $result = $conn->query($sql); 

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['Blood_bank_name'] . "</td>";
                    echo "<td>" . $row['location'] . "</td>";
                    echo "<td>" . $row['Blood_bank_contact'] . "</td>";
                    echo "<td>" . $row['blood_groups'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No blood bank information available</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Link to go back to admin home page -->
    <p><a href="admin.php"> </a></p>
</body>
</html>