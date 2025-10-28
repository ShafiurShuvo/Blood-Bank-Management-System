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

// Process order
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $blood_group = mysqli_real_escape_string($conn, $_POST['blood_group']);
    $units = mysqli_real_escape_string($conn, $_POST['units']);
    $urgency = mysqli_real_escape_string($conn, $_POST['urgency']);
    $source_type = mysqli_real_escape_string($conn, $_POST['source_type']);
    $source_id = mysqli_real_escape_string($conn, $_POST['source_id']);
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);
    $order_date = date('Y-m-d');
    
    $query = "INSERT INTO blood_orders (requester_type, requester_id, blood_group, units, urgency, source_type, source_id, order_date, notes) 
              VALUES ('Hospital', $hospital_id, '$blood_group', $units, '$urgency', '$source_type', $source_id, '$order_date', '$notes')";
    
    if (mysqli_query($conn, $query)) {
        $success = "Blood order request submitted successfully!";
    } else {
        $error = "Failed to submit order request!";
    }
}

// Get blood banks with inventory
$blood_banks = mysqli_query($conn, "SELECT DISTINCT bb.* FROM blood_banks bb 
                                     JOIN blood_inventory bi ON bb.blood_bank_id = bi.blood_bank_id 
                                     WHERE bi.units_available > 0 
                                     ORDER BY bb.city, bb.name");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Blood - Hospital</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <header class="dashboard-header">
                <h1>Order Blood</h1>
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
                    <h2>Request Blood</h2>
                    
                    <form method="POST" action="" class="order-form">
                        <div class="form-group">
                            <label for="blood_group">Blood Group Needed:</label>
                            <select name="blood_group" id="blood_group" required>
                                <option value="">Select blood group</option>
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
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="units">Units Required:</label>
                                <input type="number" name="units" id="units" min="1" max="50" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="urgency">Urgency Level:</label>
                                <select name="urgency" id="urgency" required>
                                    <option value="Low">Low</option>
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                    <option value="Critical">Critical</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="source_type">Request From:</label>
                            <select name="source_type" id="source_type" required>
                                <option value="BloodBank">Blood Bank</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="source_id">Select Blood Bank:</label>
                            <select name="source_id" id="source_id" required>
                                <option value="">Choose a blood bank</option>
                                <?php while ($bank = mysqli_fetch_assoc($blood_banks)): ?>
                                    <option value="<?php echo $bank['blood_bank_id']; ?>">
                                        <?php echo $bank['name'] . ' - ' . $bank['city']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="notes">Additional Notes:</label>
                            <textarea name="notes" id="notes" rows="4" placeholder="Provide any additional information about your request..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-large">Submit Order Request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

