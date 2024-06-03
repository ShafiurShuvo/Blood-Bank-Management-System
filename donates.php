<?php
session_start();
include "connection.php"; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $user_id = $_SESSION['user_id'];
    $age = $_POST['age'];
    $medical_condition = $_POST['medical_condition'];
    $blood_group = $_POST['blood_group'];
    $blood_bank_id = $_POST['blood_bank_id'];
    $donation_date = $_POST['donation_date'];
    $unit = $_POST['unit'];

    // Insert donation data into the database
    $donation_sql = "INSERT INTO donates_in (user_id, blood_bank_id, donation_date, blood_id) VALUES ('$user_id', '$blood_bank_id', '$donation_date', '$unit')";
    $sql = "INSERT INTO donor (D_user_id, age, medical_condition, blood_group) VALUES ('$user_id', '$age', '$medical_condition', '$blood_group')";
    
    if ($conn->query($sql) === TRUE) {
        $donor_id = $conn->insert_id;
        header("Location: user_home.php");
        
        
        // if ($conn->query($donation_sql) === TRUE) {
            // Donation successfully recorded
            echo "Donation recorded successfully!";
        // } else {
            echo "Error: " . $donation_sql . "<br>" . $conn->error;
        // }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Donate Blood</title>
    <!-- Your CSS and other meta tags here -->
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Add necessary CSS styles -->
    <style>
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

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        h2 {
            color: #333;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <!-- Navbar content -->
        <i class='bx bx-user'></i><?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?>
        <a href="user_home.php"><i class='bx bx-home' ></i> Home</a>
        <a href="user_profile.php">Profile</a>
        <a href="search_blood.php">Search Blood</a><!-- <a href="#">History</a>
        <a href="#">My Order</a> -->
        <a href="donates.php">Donate</a>
        <a href="feedback.php">Feedback</a>
        <a href="logout.php">Log Out <i class='bx bx-log-out'></i></a>
    </div>
    <div class="container">
        <h2>Donate Blood</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required><br><br>

            <label for="medical_condition">Medical Condition:</label>
            <textarea id="medical_condition" name="medical_condition" required></textarea>
            <label for="medical_condition">you can write null if there is nothing important to mention</label><br>

            <label for="blood_group">Blood Group:</label>
            <select id="blood_group" name="blood_group" required>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option> 
                    <option value="B+">B+</option> 
                    <option value="B-">B-</option> 
                    <option value="O+">O+</option> 
                    <option value="0+">O-</option> 
                    <option value="AB+">AB+</option>  
                    <option value="AB-">AB-</option><br><br>
                    <!-- Add other blood groups -->
                </select><br><br>
            <label for="blood_bank_id">Select Blood Bank:</label>
            <select id="blood_bank_id" name="blood_bank_id" required>
                <!-- Fetch and display available blood banks from the database -->
                <?php
                $sql_blood_banks = "SELECT * FROM blood_bank";
                $result_blood_banks = $conn->query($sql_blood_banks);
                if ($result_blood_banks->num_rows > 0) {
                    while ($row = $result_blood_banks->fetch_assoc()) {
                        echo "<option value='" . $row['blood_bank_id'] . "'>" . $row['Blood_bank_name'] . "</option>";
                    }
                }
                ?>
            </select><br><br>


            <label for="donation_date">Donation Date:</label>
            <input type="date" id="donation_date" name="donation_date" required><br><br>

            <label for="unit">Unit</label>
            <input type=" " id="unit" name="unit" value="1"><br><br>

            <button type="submit">Submit</button> 
            <!-- <a href="user_home.php">Submit</a> -->
            
        </form>
    </div>
</body>
</html>