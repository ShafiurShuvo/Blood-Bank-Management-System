<?php
// Start the session to access user data
session_start();

include "connection.php"; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the credentials are from the user table
    $sql3 = "SELECT * FROM `admin` WHERE email='$email' and `password`='$password'";
    $result3 = $conn->query($sql3);


    if ($result3->num_rows > 0) {
        $row = $result3->fetch_assoc();

        // Store user information in session variables
        $_SESSION['admin_id'] = $row['admin_id'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['Admin_Email'] = $row['Admin_Email'];
        // $_SESSION['address'] = $row['address'];

        // Redirect to user home page
        header("Location: admin_home.php");
        exit();
    }

     else {
        echo "Invalid email or password";
    }
}


$conn->close();
?>

<!-- HTML for user_home.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Home</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        /* Example styles for a more refined home page layout */

        /* Reset default margin and padding */
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

        /* Container for user details */
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .user-details {
            text-align: center;
            margin-top: 20px;
        }
        .user-details h2 {
            font-size: 2em;
            margin-bottom: 10px;
        }
        .user-details p {
            font-size: 1.1em;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <!-- Your navbar containing buttons like search blood, profile, History, my order, donation, and report -->
        <i class='bx bx-user'></i><?php echo $_SESSION['name']; ?>
        <a href="admin_home.php">Home</a>
        <a href="admin_profile.php">Profile</a>
        <a href="#">Patient List</a>
        <a href="#">Donor List</a>
        <a href="#">Hospital List</a>
        <a href="#">Blood Bank List</a>
        <a href="logout.php">Log Out <i class='bx bx-log-out'></i></a>
    </div>

    <div class="container">
        <div class="user-details">
            <h2>Welcome, <?php echo $_SESSION['name']; ?>!</h2>
            <!-- <p>Admin ID: <?php echo $_SESSION['admin_id']; ?></p>
            <p>Admin Name: <?php echo $_SESSION['name']; ?></p>
            <p>Email: <?php echo $_SESSION['Admin_Email']; ?></p> -->
            <!-- Display other user details as needed -->
        </div>
    </div>
</body>
</html>
