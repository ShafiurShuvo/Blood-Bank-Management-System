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
              VALUES ('User', $user_id, '$blood_group', $units, '$urgency', '$source_type', $source_id, '$order_date', '$notes')";
    
    if (mysqli_query($conn, $query)) {
        $success = "Blood order request submitted successfully!";
    } else {
        $error = "Failed to submit order request!";
    }
}

// Get blood banks with inventory
$blood_banks = mysqli_query($conn, "SELECT DISTINCT bb.*, bi.blood_group, bi.units_available 
                                     FROM blood_banks bb 
                                     JOIN blood_inventory bi ON bb.blood_bank_id = bi.blood_bank_id 
                                     WHERE bi.units_available > 0 
                                     ORDER BY bb.city, bb.name");

// Get available donors
$donors = mysqli_query($conn, "SELECT user_id, full_name, blood_group, city, state 
                               FROM users 
                               WHERE is_donor = 1 AND is_blocked = 0 AND user_id != $user_id 
                               ORDER BY blood_group, city");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Blood - Blood Bank</title>
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
                    
                    <form method="POST" action="" class="order-form" id="orderForm">
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
                                <input type="number" name="units" id="units" min="1" max="10" required>
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
                            <select name="source_type" id="source_type" required onchange="toggleSourceOptions()">
                                <option value="">Select source</option>
                                <option value="BloodBank">Blood Bank</option>
                                <option value="Donor">Individual Donor</option>
                            </select>
                        </div>
                        
                        <div class="form-group" id="bloodBankOptions" style="display: none;">
                            <label for="blood_bank_source">Select Blood Bank:</label>
                            <select name="source_id" id="blood_bank_source">
                                <option value="">Choose a blood bank</option>
                                <?php 
                                mysqli_data_seek($blood_banks, 0);
                                $current_bank = null;
                                while ($bank = mysqli_fetch_assoc($blood_banks)): 
                                    if ($current_bank != $bank['blood_bank_id']):
                                        $current_bank = $bank['blood_bank_id'];
                                ?>
                                    <option value="<?php echo $bank['blood_bank_id']; ?>">
                                        <?php echo $bank['name'] . ' - ' . $bank['city']; ?>
                                    </option>
                                <?php 
                                    endif;
                                endwhile; 
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group" id="donorOptions" style="display: none;">
                            <label for="donor_source">Select Donor:</label>
                            <select name="source_id_donor" id="donor_source">
                                <option value="">Choose a donor</option>
                                <?php while ($donor = mysqli_fetch_assoc($donors)): ?>
                                    <option value="<?php echo $donor['user_id']; ?>">
                                        <?php echo $donor['full_name'] . ' (' . $donor['blood_group'] . ') - ' . $donor['city']; ?>
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
    
    <script>
        function toggleSourceOptions() {
            var sourceType = document.getElementById('source_type').value;
            var bloodBankOptions = document.getElementById('bloodBankOptions');
            var donorOptions = document.getElementById('donorOptions');
            var bloodBankSelect = document.getElementById('blood_bank_source');
            var donorSelect = document.getElementById('donor_source');
            
            if (sourceType == 'BloodBank') {
                bloodBankOptions.style.display = 'block';
                donorOptions.style.display = 'none';
                bloodBankSelect.name = 'source_id';
                donorSelect.name = 'source_id_donor';
                bloodBankSelect.required = true;
                donorSelect.required = false;
            } else if (sourceType == 'Donor') {
                bloodBankOptions.style.display = 'none';
                donorOptions.style.display = 'block';
                bloodBankSelect.name = 'source_id_bank';
                donorSelect.name = 'source_id';
                bloodBankSelect.required = false;
                donorSelect.required = true;
            } else {
                bloodBankOptions.style.display = 'none';
                donorOptions.style.display = 'none';
                bloodBankSelect.required = false;
                donorSelect.required = false;
            }
        }
    </script>
</body>
</html>

