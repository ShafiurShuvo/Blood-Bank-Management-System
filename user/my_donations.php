<?php
require_once '../config/session.php';
require_once '../config/db_connect.php';

requireLogin();
if (!isUser()) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get all donations
$donations = mysqli_query($conn, "SELECT bd.*, bb.name as blood_bank_name, bb.city, bb.phone 
                                  FROM blood_donations bd 
                                  JOIN blood_banks bb ON bd.blood_bank_id = bb.blood_bank_id 
                                  WHERE bd.donor_id = $user_id 
                                  ORDER BY bd.created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Donations - Blood Bank</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <header class="dashboard-header">
                <h1>My Donations</h1>
                <div class="user-info">
                    <a href="../logout.php" class="btn btn-logout">Logout</a>
                </div>
            </header>
            
            <div class="content-wrapper">
                <div class="table-card">
                    <h2>Donation History</h2>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Donation ID</th>
                                    <th>Blood Bank</th>
                                    <th>Location</th>
                                    <th>Blood Group</th>
                                    <th>Units</th>
                                    <th>Donation Date</th>
                                    <th>Status</th>
                                    <th>Submitted On</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($donations) > 0): ?>
                                    <?php while ($donation = mysqli_fetch_assoc($donations)): ?>
                                        <tr>
                                            <td>#<?php echo $donation['donation_id']; ?></td>
                                            <td><?php echo $donation['blood_bank_name']; ?></td>
                                            <td><?php echo $donation['city']; ?></td>
                                            <td><strong><?php echo $donation['blood_group']; ?></strong></td>
                                            <td><?php echo $donation['units']; ?></td>
                                            <td><?php echo date('M d, Y', strtotime($donation['donation_date'])); ?></td>
                                            <td><span class="badge badge-<?php echo strtolower($donation['status']); ?>"><?php echo $donation['status']; ?></span></td>
                                            <td><?php echo date('M d, Y', strtotime($donation['created_at'])); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No donations yet. <a href="donate_blood.php">Donate now</a></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

