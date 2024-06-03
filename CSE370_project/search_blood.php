<?php
session_start(); // Start the session

include "connection.php"; // Include your database connection file

// Check if the user is logged in, redirect to login if not
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Replace "login.php" with your login page
    exit();
}

// Function to check if the blood is already ordered
// function bloodIsOrdered($bloodId) {
//     include "connection.php"; // Include your database connection file
    
//     // Check if the blood is ordered by the current user
//     //$userId = $_SESSION['user_id'];

//     // $sql = "SELECT * FROM donor WHERE d_user_id = '$d_user_id' AND blood_id = '$bloodId'";
//     $sql = "SELECT * FROM donor WHERE blood_id = '$bloodId'";
//     $result = $conn->query($sql);

//     if ($result->num_rows > 0) {
//         // Blood is already ordered by the user
//         return true;
//     } else {
//         // Blood is not ordered by the user
//         return false;
//     }
// }


// Fetch blood search results from multiple tables using JOIN
$sql = "
SELECT 
    user.first_name, 
    donor.blood_group, 
    donates_in.unit, 
    donor.blood_id, 
    blood_bank.Blood_bank_name
FROM 
    user
JOIN 
    donor ON user.user_id = donor.D_user_id
JOIN 
    donates_in ON donor.D_user_id = donates_in.user_id
JOIN 
    blood_bank ON donates_in.blood_bank_id = blood_bank.blood_bank_id
JOIN 
    search_in ON blood_bank.blood_bank_id = search_in.blood_bank_id
";


$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search Blood Results</title>
    <!-- Your CSS and other meta tags here -->
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        /* Existing CSS styles */
        /* Example styles for search blood results */

        /* Reset default margin and padding */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Navbar styling - add your specific styles */
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

        /* Table styles */
        table {
            width: 90%;
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

        /* Additional styles for buttons */
        .order-btn {
            padding: 6px 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .order-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <!-- Your navbar containing buttons like search blood, profile, History, my order, donation, and report -->
        <i class='bx bx-user'></i><?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?>
        <a href="user_home.php"><i class='bx bx-home' ></i> Home</a>
        <a href="user_profile.php">Profile</a>
        <a href="search_blood.php">Search Blood</a><!-- <a href="#">History</a>
        <a href="#">My Order</a> -->
        <a href="donates.php">Donate</a>
        <a href="feedback.php">Feedback</a>
        <a href="logout.php">Log Out <i class='bx bx-log-out'></i></a>
        <!-- Add necessary links to these buttons -->
    </div>

    <h2>Blood Search Results</h2>
    <table>
        <thead>
            <!-- Table header -->
            <tr>
                <th>First Name</th>
                <th>Blood Group</th>
                <th>Unit</th>
                <th>Blood ID</th>
                <th>Blood Bank Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    // Display data in table cells
                    echo "<td>" . $row['first_name'] . "</td>";
                    echo "<td>" . $row['blood_group'] . "</td>";
                    echo "<td>" . $row['unit'] . "</td>";
                    echo "<td>" . $row['blood_id'] . "</td>";
                    echo "<td>" . $row['Blood_bank_name'] . "</td>";

                    // Order button with form to delete data on click
                    echo "<td>";
                    // if (bloodIsOrdered($row['blood_id'])) {
                    //     echo "<span class='ordered'>Ordered</span>";
                    // } else {
                        echo "<form method='post' action='process_order3.php'>";
                        echo "<input type='hidden' name='blood_id' value='" . $row['blood_id'] . "'>";
                        echo "<input type='submit' class='order-btn' value='Order'>";
                        echo "</form>";
                    // }
                    echo "</td>";
                            }
            } else {
                echo "<tr><td colspan='6'>No blood search results found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>