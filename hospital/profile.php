<?php
require_once '../config/session.php';
require_once '../config/db_connect.php';

requireLogin();
if (!isHospital()) {
    header("Location: ../login.php");
    exit();
}

$hospital_id = $_SESSION['hospital_id'];
$success = '';
$error = '';

// Update profile
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hospital_name = mysqli_real_escape_string($conn, $_POST['hospital_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    
    $query = "UPDATE hospitals SET hospital_name = '$hospital_name', phone = '$phone', 
              address = '$address', city = '$city', state = '$state' WHERE hospital_id = $hospital_id";
    
    if (mysqli_query($conn, $query)) {
        $success = "Profile updated successfully!";
        $_SESSION['hospital_name'] = $hospital_name;
    } else {
        $error = "Failed to update profile!";
    }
}

// Get hospital details
$hospital_query = mysqli_query($conn, "SELECT * FROM hospitals WHERE hospital_id = $hospital_id");
$hospital = mysqli_fetch_assoc($hospital_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Profile - Blood Bank</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <header class="dashboard-header">
                <h1>Hospital Profile</h1>
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
                    <h2>Hospital Information</h2>
                    <form method="POST" action="" class="profile-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Hospital Name:</label>
                                <input type="text" name="hospital_name" value="<?php echo $hospital['hospital_name']; ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label>License Number:</label>
                                <input type="text" value="<?php echo $hospital['license_number']; ?>" disabled>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>Email:</label>
                                <input type="email" value="<?php echo $hospital['email']; ?>" disabled>
                            </div>
                            
                            <div class="form-group">
                                <label>Phone:</label>
                                <input type="tel" name="phone" value="<?php echo $hospital['phone']; ?>" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Address:</label>
                            <textarea name="address" rows="3" required><?php echo $hospital['address']; ?></textarea>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>City:</label>
                                <input type="text" name="city" value="<?php echo $hospital['city']; ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label>State:</label>
                                <input type="text" name="state" value="<?php echo $hospital['state']; ?>" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Registered On:</label>
                            <input type="text" value="<?php echo date('F d, Y', strtotime($hospital['created_at'])); ?>" disabled>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

