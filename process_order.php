<?php
session_start(); // Start the session

include "connection.php"; // Include your database connection file

// function bloodIsOrdered($bloodId) {
//     // Implement the logic to check if the blood is already ordered by the user
//     // Example:
//     // SELECT * FROM orders WHERE user_id = {$_SESSION['user_id']} AND blood_id = '$bloodId'
//     // Check the existence of an order for this user and blood ID

//     return false; // Replace this with your logic

// }

// $d_user_id = $_POST['d_user_id'];
// $bloodId = $_POST['blood_id'];


// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST1['d_user_id']) and isset($_POST2['user_id'])) {
    // Get the blood ID from the form submission
    $user_d = $_POST2['user_id'];
    $d_user_id = $_POST1['d_user_id'];

    // Perform deletion from connected tables based on blood ID
    // Adjust the deletion queries based on your database schema
    $deleteQueries = [
        // "DELETE FROM donor WHERE blood_id = '$bloodId'",
        // "DELETE FROM donates_in WHERE blood_id = '$bloodId'",
        
        "DELETE FROM donates_in WHERE user_id = '$user_id'",
        "DELETE FROM donor WHERE d_user_id = '$d_user_id'",
        // Add more delete queries for other connected tables as needed
    ];

    // Execute the deletion queries
    foreach ($deleteQueries as $query) {
        $conn->query($query);
    }
    
    // Redirect back to search_blood.php or any desired page after deletion
    echo "Order successful";
    header("Location: search_blood.php");
    exit();
// }

header("Location: search_blood.php");
exit();
$conn->close(); // Close the database connection
?>