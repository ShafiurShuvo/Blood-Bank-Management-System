<?php
require_once 'config/session.php';
require_once 'config/db_connect.php';

// Redirect if already logged in
if (isLoggedIn()) {
    redirectToDashboard();
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_type = $_POST['user_type'];
    
    if ($user_type == 'user') {
        // Register User
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = md5($_POST['password']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $blood_group = mysqli_real_escape_string($conn, $_POST['blood_group']);
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        $dob = mysqli_real_escape_string($conn, $_POST['dob']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $city = mysqli_real_escape_string($conn, $_POST['city']);
        $state = mysqli_real_escape_string($conn, $_POST['state']);
        $is_donor = isset($_POST['is_donor']) ? 1 : 0;
        
        // Check if email already exists
        $check = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
        if (mysqli_num_rows($check) > 0) {
            $error = "Email already registered!";
        } else {
            $query = "INSERT INTO users (full_name, email, password, phone, blood_group, gender, date_of_birth, address, city, state, is_donor) 
                      VALUES ('$full_name', '$email', '$password', '$phone', '$blood_group', '$gender', '$dob', '$address', '$city', '$state', $is_donor)";
            
            if (mysqli_query($conn, $query)) {
                $success = "Registration successful! You can now login.";
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    } elseif ($user_type == 'hospital') {
        // Register Hospital
        $hospital_name = mysqli_real_escape_string($conn, $_POST['hospital_name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = md5($_POST['password']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $city = mysqli_real_escape_string($conn, $_POST['city']);
        $state = mysqli_real_escape_string($conn, $_POST['state']);
        $license_number = mysqli_real_escape_string($conn, $_POST['license_number']);
        
        // Check if email already exists
        $check = mysqli_query($conn, "SELECT * FROM hospitals WHERE email = '$email'");
        if (mysqli_num_rows($check) > 0) {
            $error = "Email already registered!";
        } else {
            $query = "INSERT INTO hospitals (hospital_name, email, password, phone, address, city, state, license_number) 
                      VALUES ('$hospital_name', '$email', '$password', '$phone', '$address', '$city', '$state', '$license_number')";
            
            if (mysqli_query($conn, $query)) {
                $success = "Hospital registration successful! You can now login.";
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Blood Bank System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-box register-box">
            <div class="auth-header">
                <h1>🩸 Blood Bank</h1>
                <h2>Create New Account</h2>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="" class="auth-form" id="registerForm">
                <div class="form-group">
                    <label for="user_type">Register As:</label>
                    <select name="user_type" id="user_type" required onchange="toggleFormFields()">
                        <option value="user">User/Donor</option>
                        <option value="hospital">Hospital</option>
                    </select>
                </div>
                
                <div id="userFields">
                    <div class="form-group">
                        <label for="full_name">Full Name:</label>
                        <input type="text" id="full_name" name="full_name" placeholder="Enter your full name">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="blood_group">Blood Group:</label>
                            <select id="blood_group" name="blood_group">
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="gender">Gender:</label>
                            <select id="gender" name="gender">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="dob">Date of Birth:</label>
                        <input type="date" id="dob" name="dob">
                    </div>
                    
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="is_donor" id="is_donor">
                            I want to register as a blood donor
                        </label>
                    </div>
                </div>
                
                <div id="hospitalFields" style="display: none;">
                    <div class="form-group">
                        <label for="hospital_name">Hospital Name:</label>
                        <input type="text" id="hospital_name" name="hospital_name" placeholder="Enter hospital name">
                    </div>
                    
                    <div class="form-group">
                        <label for="license_number">License Number:</label>
                        <input type="text" id="license_number" name="license_number" placeholder="Enter license number">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="tel" id="phone" name="phone" placeholder="Enter phone number" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Enter password" required>
                </div>
                
                <div class="form-group">
                    <label for="address">Address:</label>
                    <textarea id="address" name="address" rows="3" placeholder="Enter full address" required></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="city">City:</label>
                        <input type="text" id="city" name="city" placeholder="City" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="state">State:</label>
                        <input type="text" id="state" name="state" placeholder="State" required>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </form>
            
            <div class="auth-footer">
                <p>Already have an account? <a href="login.php">Login here</a></p>
                <p><a href="index.php">Back to Home</a></p>
            </div>
        </div>
    </div>
    
    <script>
        function toggleFormFields() {
            var userType = document.getElementById('user_type').value;
            var userFields = document.getElementById('userFields');
            var hospitalFields = document.getElementById('hospitalFields');
            
            if (userType == 'user') {
                userFields.style.display = 'block';
                hospitalFields.style.display = 'none';
                // Set required
                document.getElementById('full_name').required = true;
                document.getElementById('blood_group').required = true;
                document.getElementById('gender').required = true;
                document.getElementById('dob').required = true;
                document.getElementById('hospital_name').required = false;
                document.getElementById('license_number').required = false;
            } else {
                userFields.style.display = 'none';
                hospitalFields.style.display = 'block';
                // Set required
                document.getElementById('full_name').required = false;
                document.getElementById('blood_group').required = false;
                document.getElementById('gender').required = false;
                document.getElementById('dob').required = false;
                document.getElementById('hospital_name').required = true;
                document.getElementById('license_number').required = true;
            }
        }
    </script>
</body>
</html>

