<?php
require_once '../config/session.php';
require_once '../config/db_connect.php';

requireLogin();
if (!isUser()) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$success = '';
$error = '';

// Update profile
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $is_donor = isset($_POST['is_donor']) ? 1 : 0;
    
    $query = "UPDATE users SET full_name = '$full_name', phone = '$phone', address = '$address', 
              city = '$city', state = '$state', is_donor = $is_donor WHERE user_id = $user_id";
    
    if (mysqli_query($conn, $query)) {
        $success = "Profile updated successfully!";
        $_SESSION['full_name'] = $full_name;
    } else {
        $error = "Failed to update profile!";
    }
}

// Get user details
$user_query = mysqli_query($conn, "SELECT * FROM users WHERE user_id = $user_id");
$user = mysqli_fetch_assoc($user_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Blood Bank</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <header class="dashboard-header">
                <h1>My Profile</h1>
                <div class="user-info">
                    <a href="../logout.php" class="btn btn-logout">Logout</a>
                </div>
            </header>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <div class="profile-container">
                <div class="profile-card">
                    <h2>Personal Information</h2>
                    <form method="POST" action="" class="profile-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Full Name:</label>
                                <input type="text" name="full_name" value="<?php echo $user['full_name']; ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Email:</label>
                                <input type="email" value="<?php echo $user['email']; ?>" disabled>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>Phone:</label>
                                <input type="tel" name="phone" value="<?php echo $user['phone']; ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Blood Group:</label>
                                <input type="text" value="<?php echo $user['blood_group']; ?>" disabled>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>Gender:</label>
                                <input type="text" value="<?php echo $user['gender']; ?>" disabled>
                            </div>
                            
                            <div class="form-group">
                                <label>Date of Birth:</label>
                                <input type="date" value="<?php echo $user['date_of_birth']; ?>" disabled>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Address:</label>
                            <textarea name="address" rows="3" required><?php echo $user['address']; ?></textarea>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>City:</label>
                                <input type="text" name="city" value="<?php echo $user['city']; ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label>State:</label>
                                <input type="text" name="state" value="<?php echo $user['state']; ?>" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="is_donor" <?php echo $user['is_donor'] ? 'checked' : ''; ?>>
                                I am a blood donor
                            </label>
                        </div>
                        
                        <?php if ($user['last_donation_date']): ?>
                            <div class="form-group">
                                <label>Last Donation Date:</label>
                                <input type="date" value="<?php echo $user['last_donation_date']; ?>" disabled>
                            </div>
                        <?php endif; ?>
                        
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

