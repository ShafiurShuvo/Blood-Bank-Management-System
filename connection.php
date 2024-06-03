<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "Blood_Management_System";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    // echo "<h1>DB connected!</h1>\n";
}