<?php
require_once '../config/session.php';
require_once '../config/db_connect.php';

requireLogin();
if (!isAdmin()) {
    header("Location: ../login.php");
    exit();
}

// Get all donors
$donors = mysqli_query($conn, "SELECT * FROM users WHERE is_donor = 1 ORDER BY last_donation_date DESC, created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Donors - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <header class="dashboard-header">
                <h1>Manage Donors</h1>
                <div class="user-info">
                    <a href="../logout.php" class="btn btn-logout">Logout</a>
                </div>
            </header>
            
            <div class="content-wrapper">
                <div class="table-card">
                    <h2>All Donors</h2>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Blood Group</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Last Donation</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($donor = mysqli_fetch_assoc($donors)): ?>
                                    <tr>
                                        <td>#<?php echo $donor['user_id']; ?></td>
                                        <td><?php echo $donor['full_name']; ?></td>
                                        <td><?php echo $donor['email']; ?></td>
                                        <td><?php echo $donor['phone']; ?></td>
                                        <td><strong><?php echo $donor['blood_group']; ?></strong></td>
                                        <td><?php echo $donor['city']; ?></td>
                                        <td><?php echo $donor['state']; ?></td>
                                        <td><?php echo $donor['last_donation_date'] ? date('M d, Y', strtotime($donor['last_donation_date'])) : 'Never'; ?></td>
                                        <td>
                                            <?php if ($donor['is_blocked']): ?>
                                                <span class="badge badge-rejected">Blocked</span>
                                            <?php else: ?>
                                                <span class="badge badge-approved">Active</span>
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

