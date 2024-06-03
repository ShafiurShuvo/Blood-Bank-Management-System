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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Admin Feedback</title>
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
         
        body {
            font-family: Arial, sans-serif;
        }


        /* Style for the "Next" button */
        .next-button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            position: right;
            bottom: 20px;
            right: 20px;
            z-index: 1; /* To make it appear above other elements */
        }

        /* Additional CSS for spacing */
        .table-container {
            margin-bottom: 100px; /* Adjust as needed */
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
    <h1>Welcome, Admin!</h1>

    <h2>User Feedback</h2>
    <table>
        <thead>
            <tr>
                <th>Feedback ID</th>
                <th>Message</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "connection.php"; // Include your database connection file
            
            // Perform the SQL query to retrieve feedback information
            $sql = "SELECT * FROM feedback";
            $result = $conn->query($sql); // Execute the query

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['feedback_id'] . "</td>";
                    echo "<td>" . $row['message'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan=' '>No feedback available</td></tr>";
            }

            $conn->close(); // Close the database connection
            ?>
        </tbody>
    </table>

    <!-- "Next" button linked to block_user.php -->
    <form action="block_user.php" method="post">
        <input type="submit" name="next" value="Next"> 
        
    </form>

    <!-- Link to go back to admin home page -->
    <p><a href="admin.php"> </a></p> 

</body>
</html>