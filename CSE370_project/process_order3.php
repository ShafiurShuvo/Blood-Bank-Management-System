<?php
session_start();

include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $user_id = $_POST['user_id'];
    $medicine_list = $_POST['medicine_list'];
    $doctor_advices = $_POST['doctor_advices'];
    $hospital_id = $_POST['hospital_id'];

    $sql = "INSERT INTO patient (P_user_id, medicine_list, doctor_advices, P_hospital_id)
            VALUES ('$user_id', '$medicine_list', '$doctor_advices', '$hospital_id')";

    if ($conn->query($sql) === TRUE) {
        header("Location: order_success.html");
        exit(); 
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <title>Patient Information Form</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
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
            color: #ffd700;
        }


        h2 {
            text-align: center;
            color: #333;
        }

        form {
            width: 50%;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        textarea {
            width: calc(100% - 20px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
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
    <h2>Patient Information</h2>
    <form action="order_success.html" method="post">
        <label for="medicine_list">Medicine List:</label>
        <textarea id="medicine_list" name="medicine_list" rows="4" required></textarea><br><br>

        <label for="doctor_advices">Doctor's Advices:</label>
        <textarea id="doctor_advices" name="doctor_advices" rows="4" required></textarea><br><br>

        <label for="hospital_id">Hospital ID:</label>
        <input type="text" id="hospital_id" name="hospital_id" required><br><br>

        <input type="submit" value="Proceed Order">
    </form>
</body>
</html>  

<?php
$conn->close(); 
?>