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

// Update order status
if (isset($_GET['action']) && isset($_GET['id'])) {
    $order_id = (int)$_GET['id'];
    $action = $_GET['action'];
    
    if ($action == 'approve') {
        mysqli_query($conn, "UPDATE blood_orders SET status = 'Approved' WHERE order_id = $order_id");
        $success = "Order approved successfully!";
    } elseif ($action == 'reject') {
        mysqli_query($conn, "UPDATE blood_orders SET status = 'Rejected' WHERE order_id = $order_id");
        $success = "Order rejected!";
    } elseif ($action == 'complete') {
        mysqli_query($conn, "UPDATE blood_orders SET status = 'Completed' WHERE order_id = $order_id");
        $success = "Order marked as completed!";
    }
}

// Get all orders
$orders = mysqli_query($conn, "SELECT * FROM blood_orders ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <header class="dashboard-header">
                <h1>Manage Orders</h1>
                <div class="user-info">
                    <a href="../logout.php" class="btn btn-logout">Logout</a>
                </div>
            </header>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <div class="content-wrapper">
                <div class="table-card">
                    <h2>All Orders</h2>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Requester Type</th>
                                    <th>Blood Group</th>
                                    <th>Units</th>
                                    <th>Source</th>
                                    <th>Urgency</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($order = mysqli_fetch_assoc($orders)): ?>
                                    <tr>
                                        <td>#<?php echo $order['order_id']; ?></td>
                                        <td><?php echo $order['requester_type']; ?></td>
                                        <td><strong><?php echo $order['blood_group']; ?></strong></td>
                                        <td><?php echo $order['units']; ?></td>
                                        <td><?php echo $order['source_type']; ?></td>
                                        <td><span class="badge badge-<?php echo strtolower($order['urgency']); ?>"><?php echo $order['urgency']; ?></span></td>
                                        <td><?php echo date('M d, Y', strtotime($order['order_date'])); ?></td>
                                        <td><span class="badge badge-<?php echo strtolower($order['status']); ?>"><?php echo $order['status']; ?></span></td>
                                        <td>
                                            <?php if ($order['status'] == 'Pending'): ?>
                                                <a href="?action=approve&id=<?php echo $order['order_id']; ?>" class="btn btn-sm btn-success">Approve</a>
                                                <a href="?action=reject&id=<?php echo $order['order_id']; ?>" class="btn btn-sm btn-danger">Reject</a>
                                            <?php elseif ($order['status'] == 'Approved'): ?>
                                                <a href="?action=complete&id=<?php echo $order['order_id']; ?>" class="btn btn-sm btn-primary">Complete</a>
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

