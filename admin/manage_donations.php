<?php
require_once '../config/session.php';
require_once '../config/db_connect.php';

requireLogin();
if (!isAdmin()) {
    header("Location: ../login.php");
    exit();
}

$success = '';
$error = '';

// Update donation status
if (isset($_GET['action']) && isset($_GET['id'])) {
    $donation_id = (int)$_GET['id'];
    $action = $_GET['action'];
    
    if ($action == 'approve') {
        // Get donation details
        $donation_query = mysqli_query($conn, "SELECT * FROM blood_donations WHERE donation_id = $donation_id");
        $donation = mysqli_fetch_assoc($donation_query);
        
        // Update donation status
        mysqli_query($conn, "UPDATE blood_donations SET status = 'Approved' WHERE donation_id = $donation_id");
        
        // Update inventory
        $inventory_check = mysqli_query($conn, "SELECT * FROM blood_inventory 
                                                WHERE blood_bank_id = {$donation['blood_bank_id']} 
                                                AND blood_group = '{$donation['blood_group']}'");
        
        if (mysqli_num_rows($inventory_check) > 0) {
            mysqli_query($conn, "UPDATE blood_inventory 
                                SET units_available = units_available + {$donation['units']} 
                                WHERE blood_bank_id = {$donation['blood_bank_id']} 
                                AND blood_group = '{$donation['blood_group']}'");
        } else {
            mysqli_query($conn, "INSERT INTO blood_inventory (blood_bank_id, blood_group, units_available) 
                                VALUES ({$donation['blood_bank_id']}, '{$donation['blood_group']}', {$donation['units']})");
        }
        
        $success = "Donation approved successfully!";
    } elseif ($action == 'reject') {
        mysqli_query($conn, "UPDATE blood_donations SET status = 'Rejected' WHERE donation_id = $donation_id");
        $success = "Donation rejected!";
    }
}

// Get all donations
$donations = mysqli_query($conn, "SELECT bd.*, u.full_name, u.email, bb.name as blood_bank_name 
                                  FROM blood_donations bd 
                                  JOIN users u ON bd.donor_id = u.user_id 
                                  JOIN blood_banks bb ON bd.blood_bank_id = bb.blood_bank_id 
                                  ORDER BY bd.created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Donations - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <header class="dashboard-header">
                <h1>Manage Donations</h1>
                <div class="user-info">
                    <a href="../logout.php" class="btn btn-logout">Logout</a>
                </div>
            </header>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <div class="content-wrapper">
                <div class="table-card">
                    <h2>All Donations</h2>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Donor</th>
                                    <th>Email</th>
                                    <th>Blood Bank</th>
                                    <th>Blood Group</th>
                                    <th>Units</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($donation = mysqli_fetch_assoc($donations)): ?>
                                    <tr>
                                        <td>#<?php echo $donation['donation_id']; ?></td>
                                        <td><?php echo $donation['full_name']; ?></td>
                                        <td><?php echo $donation['email']; ?></td>
                                        <td><?php echo $donation['blood_bank_name']; ?></td>
                                        <td><strong><?php echo $donation['blood_group']; ?></strong></td>
                                        <td><?php echo $donation['units']; ?></td>
                                        <td><?php echo date('M d, Y', strtotime($donation['donation_date'])); ?></td>
                                        <td><span class="badge badge-<?php echo strtolower($donation['status']); ?>"><?php echo $donation['status']; ?></span></td>
                                        <td>
                                            <?php if ($donation['status'] == 'Pending'): ?>
                                                <a href="?action=approve&id=<?php echo $donation['donation_id']; ?>" class="btn btn-sm btn-success">Approve</a>
                                                <a href="?action=reject&id=<?php echo $donation['donation_id']; ?>" class="btn btn-sm btn-danger">Reject</a>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

