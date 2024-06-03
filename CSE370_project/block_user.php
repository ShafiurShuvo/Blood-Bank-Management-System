<?php

// Check if the form is submitted to block a user
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["block_user"])) {

    $user_id = $_POST["user_id"]; // Get the feedback ID to block from the form

    // Perform the action to block the user based on the feedback ID
    $sql1 = "DELETE FROM user WHERE user_id = '$user_id'"; // Remove user from gives table
    $result1 = $conn->query($sql1); 

    // $sql2 = "DELETE FROM blood_bank WHERE blood_bank_id = $blood_bank_name_to_block"; // Remove user from gives table
    // $result2 = $conn->query($sql2); 
 
    // $sql3 = "DELETE FROM hospital WHERE hospital_id = $hospital_name_to_block"; // Remove user from gives table
    // $result3 = $conn->query($sql3);

    $sql = "UPDATE user SET blocked='YES' WHERE user_id = ?";

    // Prepare and bind the statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $user_id); // 'i' indicates integer type for user_id

        // Execute the update
        if ($stmt->execute()) {
            echo "User with ID $user_id has been blocked.";
        } else {
            echo "Error blocking user.";
        }

        $stmt->close();
    }
    header("Location: feedback_list.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Block User by Feedback ID</title>
    <!-- Add your CSS styles or link CSS files here -->
    <style>
        /* Example CSS styles */
        /* Add your CSS styles here */
        .block-form {
            margin: 20px;
        }
        .block-form label {
            display: block;
            margin-bottom: 10px;
        }
        .block-form input[type="text"] {
            width: 200px;
            padding: 5px;
        }
        .block-form input[type="submit"] {
            padding: 8px 16px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .block-form input[type="submit"]:hover {
            background-color: #d32f2f;
        }
    </style>
</head>


<body>
    <h1>Welcome, Admin!</h1>

    <h2>Block User by Feedback ID</h2>
    
    <form class="block-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="feedback_id_to_block">Enter User ID to Block:</label>
        <input type="text" name="feedback_id_to_block" id="feedback_id_to_block">
        <br><br>
        <input type="submit" name="block_user" value="Block">
    </form>

    <!-- Link to go back to admin home page -->
    <p><a href="block_user.php"></a></p>
</body>
</html>