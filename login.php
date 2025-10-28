<?php
require_once 'config/session.php';
require_once 'config/db_connect.php';

// Redirect if already logged in
if (isLoggedIn()) {
    redirectToDashboard();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $user_type = $_POST['user_type'];
    
    if ($user_type == 'user') {
        // Check in users table
        $query = "SELECT * FROM users WHERE email = '$email' AND is_blocked = 0";
        $result = mysqli_query($conn, $query);
        
        if ($result && mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            if (md5($password) == $user['password']) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['email'] = $user['email'];
                header("Location: user/dashboard.php");
                exit();
            } else {
                $error = "Invalid password!";
            }
        } else {
            $error = "User not found or account is blocked!";
        }
    } elseif ($user_type == 'hospital') {
        // Check in hospitals table
        $query = "SELECT * FROM hospitals WHERE email = '$email' AND is_blocked = 0";
        $result = mysqli_query($conn, $query);
        
        if ($result && mysqli_num_rows($result) == 1) {
            $hospital = mysqli_fetch_assoc($result);
            if (md5($password) == $hospital['password']) {
                $_SESSION['hospital_id'] = $hospital['hospital_id'];
                $_SESSION['hospital_name'] = $hospital['hospital_name'];
                $_SESSION['email'] = $hospital['email'];
                header("Location: hospital/dashboard.php");
                exit();
            } else {
                $error = "Invalid password!";
            }
        } else {
            $error = "Hospital not found or account is blocked!";
        }
    } elseif ($user_type == 'admin') {
        // Check in admins table
        $query = "SELECT * FROM admins WHERE username = '$email' OR email = '$email'";
        $result = mysqli_query($conn, $query);
        
        if ($result && mysqli_num_rows($result) == 1) {
            $admin = mysqli_fetch_assoc($result);
            if (md5($password) == $admin['password']) {
                $_SESSION['admin_id'] = $admin['admin_id'];
                $_SESSION['username'] = $admin['username'];
                $_SESSION['email'] = $admin['email'];
                header("Location: admin/dashboard.php");
                exit();
            } else {
                $error = "Invalid password!";
            }
        } else {
            $error = "Admin not found!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Blood Bank System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-box">
            <div class="auth-header">
                <h1>🩸 Blood Bank</h1>
                <h2>Login to Your Account</h2>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="" class="auth-form">
                <div class="form-group">
                    <label for="user_type">Login As:</label>
                    <select name="user_type" id="user_type" required>
                        <option value="user">User/Donor</option>
                        <option value="hospital">Hospital</option>
                        <option value="admin">Administrator</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="email">Email/Username:</label>
                    <input type="text" id="email" name="email" placeholder="Enter your email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
            
            <div class="auth-footer">
                <p>Don't have an account? <a href="register.php">Register here</a></p>
                <p><a href="index.php">Back to Home</a></p>
            </div>
        </div>
    </div>
</body>
</html>

