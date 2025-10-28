<?php
require_once '../config/session.php';
require_once '../config/db_connect.php';

requireLogin();
if (!isUser()) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get all orders
$orders = mysqli_query($conn, "SELECT * FROM blood_orders 
                               WHERE requester_type = 'User' AND requester_id = $user_id 
                               ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - Blood Bank</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <header class="dashboard-header">
                <h1>My Orders</h1>
                <div class="user-info">
                    <a href="../logout.php" class="btn btn-logout">Logout</a>
                </div>
            </header>
            
            <div class="content-wrapper">
                <div class="table-card">
                    <h2>Order History</h2>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Blood Group</th>
                                    <th>Units</th>
                                    <th>Source Type</th>
                                    <th>Urgency</th>
                                    <th>Order Date</th>
                                    <th>Status</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($orders) > 0): ?>
                                    <?php while ($order = mysqli_fetch_assoc($orders)): ?>
                                        <tr>
                                            <td>#<?php echo $order['order_id']; ?></td>
                                            <td><strong><?php echo $order['blood_group']; ?></strong></td>
                                            <td><?php echo $order['units']; ?></td>
                                            <td><?php echo $order['source_type']; ?></td>
                                            <td><span class="badge badge-<?php echo strtolower($order['urgency']); ?>"><?php echo $order['urgency']; ?></span></td>
                                            <td><?php echo date('M d, Y', strtotime($order['order_date'])); ?></td>
                                            <td><span class="badge badge-<?php echo strtolower($order['status']); ?>"><?php echo $order['status']; ?></span></td>
                                            <td><?php echo $order['notes'] ? substr($order['notes'], 0, 50) . '...' : '-'; ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No orders yet. <a href="order_blood.php">Order now</a></td>
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

