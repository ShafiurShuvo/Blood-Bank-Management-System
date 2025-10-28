<?php
require_once '../config/session.php';
require_once '../config/db_connect.php';

requireLogin();
if (!isUser()) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get user details
$user_query = mysqli_query($conn, "SELECT * FROM users WHERE user_id = $user_id");
$user = mysqli_fetch_assoc($user_query);

// Get statistics
$my_donations = mysqli_query($conn, "SELECT COUNT(*) as count FROM blood_donations WHERE donor_id = $user_id");
$donations_count = mysqli_fetch_assoc($my_donations)['count'];

$my_orders = mysqli_query($conn, "SELECT COUNT(*) as count FROM blood_orders WHERE requester_type = 'User' AND requester_id = $user_id");
$orders_count = mysqli_fetch_assoc($my_orders)['count'];

// Get recent activities
$recent_donations = mysqli_query($conn, "SELECT bd.*, bb.name as blood_bank_name 
                                         FROM blood_donations bd 
                                         JOIN blood_banks bb ON bd.blood_bank_id = bb.blood_bank_id 
                                         WHERE bd.donor_id = $user_id 
                                         ORDER BY bd.created_at DESC LIMIT 5");

$recent_orders = mysqli_query($conn, "SELECT * FROM blood_orders 
                                      WHERE requester_type = 'User' AND requester_id = $user_id 
                                      ORDER BY created_at DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Blood Bank</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <header class="dashboard-header">
                <h1>Welcome, <?php echo $user['full_name']; ?>!</h1>
                <div class="user-info">
                    <span>Blood Group: <strong><?php echo $user['blood_group']; ?></strong></span>
                    <a href="../logout.php" class="btn btn-logout">Logout</a>
                </div>
            </header>
            
            <div class="dashboard-stats">
                <div class="stat-card">
                    <div class="stat-icon">🩸</div>
                    <div class="stat-details">
                        <h3><?php echo $donations_count; ?></h3>
                        <p>Total Donations</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">📋</div>
                    <div class="stat-details">
                        <h3><?php echo $orders_count; ?></h3>
                        <p>Blood Orders</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <?php echo $user['is_donor'] ? '✓' : '✗'; ?>
                    </div>
                    <div class="stat-details">
                        <h3><?php echo $user['is_donor'] ? 'Active' : 'Inactive'; ?></h3>
                        <p>Donor Status</p>
                    </div>
                </div>
            </div>
            
            <div class="dashboard-content">
                <div class="content-section">
                    <h2>Recent Donations</h2>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Blood Bank</th>
                                    <th>Blood Group</th>
                                    <th>Units</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($recent_donations) > 0): ?>
                                    <?php while ($donation = mysqli_fetch_assoc($recent_donations)): ?>
                                        <tr>
                                            <td><?php echo $donation['blood_bank_name']; ?></td>
                                            <td><?php echo $donation['blood_group']; ?></td>
                                            <td><?php echo $donation['units']; ?></td>
                                            <td><?php echo date('M d, Y', strtotime($donation['donation_date'])); ?></td>
                                            <td><span class="badge badge-<?php echo strtolower($donation['status']); ?>"><?php echo $donation['status']; ?></span></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No donations yet</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="content-section">
                    <h2>Recent Orders</h2>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Blood Group</th>
                                    <th>Units</th>
                                    <th>Urgency</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($recent_orders) > 0): ?>
                                    <?php while ($order = mysqli_fetch_assoc($recent_orders)): ?>
                                        <tr>
                                            <td><?php echo $order['blood_group']; ?></td>
                                            <td><?php echo $order['units']; ?></td>
                                            <td><span class="badge badge-<?php echo strtolower($order['urgency']); ?>"><?php echo $order['urgency']; ?></span></td>
                                            <td><?php echo date('M d, Y', strtotime($order['order_date'])); ?></td>
                                            <td><span class="badge badge-<?php echo strtolower($order['status']); ?>"><?php echo $order['status']; ?></span></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No orders yet</td>
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

