<?php
require_once '../config/session.php';
require_once '../config/db_connect.php';

requireLogin();
if (!isHospital()) {
    header("Location: ../login.php");
    exit();
}

$hospital_id = $_SESSION['hospital_id'];

// Get hospital details
$hospital_query = mysqli_query($conn, "SELECT * FROM hospitals WHERE hospital_id = $hospital_id");
$hospital = mysqli_fetch_assoc($hospital_query);

// Get statistics
$my_orders = mysqli_query($conn, "SELECT COUNT(*) as count FROM blood_orders WHERE requester_type = 'Hospital' AND requester_id = $hospital_id");
$orders_count = mysqli_fetch_assoc($my_orders)['count'];

$pending_orders = mysqli_query($conn, "SELECT COUNT(*) as count FROM blood_orders WHERE requester_type = 'Hospital' AND requester_id = $hospital_id AND status = 'Pending'");
$pending_count = mysqli_fetch_assoc($pending_orders)['count'];

// Get recent orders
$recent_orders = mysqli_query($conn, "SELECT * FROM blood_orders 
                                      WHERE requester_type = 'Hospital' AND requester_id = $hospital_id 
                                      ORDER BY created_at DESC LIMIT 10");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Dashboard - Blood Bank</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <header class="dashboard-header">
                <h1>Welcome, <?php echo $hospital['hospital_name']; ?>!</h1>
                <div class="user-info">
                    <a href="../logout.php" class="btn btn-logout">Logout</a>
                </div>
            </header>
            
            <div class="dashboard-stats">
                <div class="stat-card">
                    <div class="stat-icon">📋</div>
                    <div class="stat-details">
                        <h3><?php echo $orders_count; ?></h3>
                        <p>Total Orders</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">⏳</div>
                    <div class="stat-details">
                        <h3><?php echo $pending_count; ?></h3>
                        <p>Pending Orders</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">🏥</div>
                    <div class="stat-details">
                        <h3><?php echo $hospital['city']; ?></h3>
                        <p>Location</p>
                    </div>
                </div>
            </div>
            
            <div class="dashboard-content">
                <div class="content-section">
                    <h2>Recent Blood Orders</h2>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Blood Group</th>
                                    <th>Units</th>
                                    <th>Urgency</th>
                                    <th>Source</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($recent_orders) > 0): ?>
                                    <?php while ($order = mysqli_fetch_assoc($recent_orders)): ?>
                                        <tr>
                                            <td>#<?php echo $order['order_id']; ?></td>
                                            <td><strong><?php echo $order['blood_group']; ?></strong></td>
                                            <td><?php echo $order['units']; ?></td>
                                            <td><span class="badge badge-<?php echo strtolower($order['urgency']); ?>"><?php echo $order['urgency']; ?></span></td>
                                            <td><?php echo $order['source_type']; ?></td>
                                            <td><?php echo date('M d, Y', strtotime($order['order_date'])); ?></td>
                                            <td><span class="badge badge-<?php echo strtolower($order['status']); ?>"><?php echo $order['status']; ?></span></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No orders yet</td>
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

