<?php
session_start(); // Start the session

include "connection.php"; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['feedback'])) {
        $message = $_POST['feedback'];

        // Insert feedback into feedback table
        $insertFeedbackQuery = "INSERT INTO feedback (message) VALUES ('$message')";
        $result = $conn->query($insertFeedbackQuery);

        if ($result) {
            $feedbackId = $conn->insert_id; // Get the ID of the inserted feedback

            // Get the user ID from the session
            $userId = $_SESSION['user_id'];

            // Insert into gives table to establish relationship
            $insertGivesQuery = "INSERT INTO gives (feedback_id, user_id) VALUES ('$feedbackId', '$userId')";
            $resultGives = $conn->query($insertGivesQuery);

            if ($resultGives) {
                echo "Feedback submitted successfully!";
                header("Location: feedback.php");
                exit();
                // Handle success, redirect or display a success message
            } else {
                echo "Error inserting into gives table: " . $conn->error;
            }
        } else {
            echo "Error inserting into feedback table: " . $conn->error;
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Feedback Form</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        /* Your CSS styles here */
        /* Example styles for the feedback form */
        /* Add any additional styling as needed */
        /* Form styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        
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


        .feedback-form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .feedback-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        .feedback-form input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .feedback-form input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="navbar">
    <i class='bx bx-user'></i><?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?>
        <a href="user_home.php"><i class='bx bx-home' ></i> Home</a>
        <a href="user_profile.php">Profile</a>
        <a href="search_blood.php">Search Blood</a><!-- <a href="#">History</a>
        <a href="#">My Order</a> -->
        <a href="donates.php">Donate</a>
        <a href="feedback.php">Feedback</a>
        <a href="logout.php">Log Out <i class='bx bx-log-out'></i></a>
    </div>

    <div class="feedback-form">
        <h2>Give Feedback</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <textarea name="feedback" rows="4" placeholder="Enter your feedback here" required></textarea>
            <input type="submit" value="Submit Feedback">
        </form>
    </div>
</body>
</html> 

