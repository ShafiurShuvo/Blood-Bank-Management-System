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

// Block/Unblock hospital
if (isset($_GET['action']) && isset($_GET['id'])) {
    $hospital_id = (int)$_GET['id'];
    $action = $_GET['action'];
    
    if ($action == 'block') {
        mysqli_query($conn, "UPDATE hospitals SET is_blocked = 1 WHERE hospital_id = $hospital_id");
        $success = "Hospital blocked successfully!";
    } elseif ($action == 'unblock') {
        mysqli_query($conn, "UPDATE hospitals SET is_blocked = 0 WHERE hospital_id = $hospital_id");
        $success = "Hospital unblocked successfully!";
    }
}

// Get all hospitals
$hospitals = mysqli_query($conn, "SELECT * FROM hospitals ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Hospitals - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <header class="dashboard-header">
                <h1>Manage Hospitals</h1>
                <div class="user-info">
                    <a href="../logout.php" class="btn btn-logout">Logout</a>
                </div>
            </header>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <div class="content-wrapper">
                <div class="table-card">
                    <h2>All Hospitals</h2>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Hospital Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>City</th>
                                    <th>License No.</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($hospital = mysqli_fetch_assoc($hospitals)): ?>
                                    <tr>
                                        <td>#<?php echo $hospital['hospital_id']; ?></td>
                                        <td><?php echo $hospital['hospital_name']; ?></td>
                                        <td><?php echo $hospital['email']; ?></td>
                                        <td><?php echo $hospital['phone']; ?></td>
                                        <td><?php echo $hospital['city']; ?></td>
                                        <td><?php echo $hospital['license_number']; ?></td>
                                        <td>
                                            <?php if ($hospital['is_blocked']): ?>
                                                <span class="badge badge-rejected">Blocked</span>
                                            <?php else: ?>
                                                <span class="badge badge-approved">Active</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($hospital['is_blocked']): ?>
                                                <a href="?action=unblock&id=<?php echo $hospital['hospital_id']; ?>" class="btn btn-sm btn-success">Unblock</a>
                                            <?php else: ?>
                                                <a href="?action=block&id=<?php echo $hospital['hospital_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Block</a>
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

