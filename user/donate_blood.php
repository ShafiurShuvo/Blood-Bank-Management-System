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

// Get user details
$user_query = mysqli_query($conn, "SELECT * FROM users WHERE user_id = $user_id");
$user = mysqli_fetch_assoc($user_query);

// Process donation
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $blood_bank_id = mysqli_real_escape_string($conn, $_POST['blood_bank_id']);
    $donation_date = mysqli_real_escape_string($conn, $_POST['donation_date']);
    $units = mysqli_real_escape_string($conn, $_POST['units']);
    
    $query = "INSERT INTO blood_donations (donor_id, blood_bank_id, blood_group, units, donation_date) 
              VALUES ($user_id, $blood_bank_id, '{$user['blood_group']}', $units, '$donation_date')";
    
    if (mysqli_query($conn, $query)) {
        // Update user's last donation date
        mysqli_query($conn, "UPDATE users SET last_donation_date = '$donation_date', is_donor = 1 WHERE user_id = $user_id");
        $success = "Blood donation request submitted successfully!";
    } else {
        $error = "Failed to submit donation request!";
    }
}

// Get blood banks
$blood_banks = mysqli_query($conn, "SELECT * FROM blood_banks ORDER BY city, name");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate Blood - Blood Bank</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <header class="dashboard-header">
                <h1>Donate Blood</h1>
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
            
            <div class="content-wrapper">
                <div class="form-card">
                    <h2>Donate Blood - Save Lives</h2>
                    <p class="info-text">Your blood group: <strong><?php echo $user['blood_group']; ?></strong></p>
                    
                    <form method="POST" action="" class="donation-form">
                        <div class="form-group">
                            <label for="blood_bank_id">Select Blood Bank:</label>
                            <select name="blood_bank_id" id="blood_bank_id" required>
                                <option value="">Choose a blood bank</option>
                                <?php while ($bank = mysqli_fetch_assoc($blood_banks)): ?>
                                    <option value="<?php echo $bank['blood_bank_id']; ?>">
                                        <?php echo $bank['name'] . ' - ' . $bank['city']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="donation_date">Donation Date:</label>
                            <input type="date" name="donation_date" id="donation_date" 
                                   min="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="units">Units to Donate:</label>
                            <input type="number" name="units" id="units" min="1" max="5" value="1" required>
                            <small>1 unit = approximately 450ml</small>
                        </div>
                        
                        <div class="donation-info">
                            <h3>Important Information:</h3>
                            <ul>
                                <li>You must be at least 18 years old and weigh at least 50kg</li>
                                <li>You should be in good health and feel well</li>
                                <li>You can donate whole blood every 56 days</li>
                                <li>Eat a healthy meal and drink plenty of water before donating</li>
                                <li>Bring a valid ID proof to the blood bank</li>
                            </ul>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-large">Submit Donation Request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

