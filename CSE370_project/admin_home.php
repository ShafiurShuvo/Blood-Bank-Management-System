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


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Home</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Add your CSS styling here -->
    <style>
        /* Style for the buttons */
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


        .button {
            display: inline-block;
            width: 200px;
            height: 100px;
            margin: 20px;
            padding: 10px;
            text-align: center;
            font-size: 18px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        /* Additional styles as needed */
        /* You can add more styling or modify based on your design requirements */
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
    <div>
    <h1>Welcome, Admin!</h1>
        <!-- Buttons for managing different lists and functionalities -->
        <a href="donor_list.php"><button class="button">Donor List</button></a>
        <a href="patient_list.php"><button class="button">Patient List</button></a>
        <a href="hospital_list.php"><button class="button">Hospital List</button></a>
        <a href="blood_bank_list.php"><button class="button">Blood Bank List</button></a>
        <a href="feedbacks_list.php"><button class="button">Feedbacks</button></a>
        <!-- Add more buttons for other functionalities as needed -->
    </div>
</body>
</html>