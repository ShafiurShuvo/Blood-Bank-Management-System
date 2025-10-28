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

// Block/Unblock user
if (isset($_GET['action']) && isset($_GET['id'])) {
    $user_id = (int)$_GET['id'];
    $action = $_GET['action'];
    
    if ($action == 'block') {
        mysqli_query($conn, "UPDATE users SET is_blocked = 1 WHERE user_id = $user_id");
        $success = "User blocked successfully!";
    } elseif ($action == 'unblock') {
        mysqli_query($conn, "UPDATE users SET is_blocked = 0 WHERE user_id = $user_id");
        $success = "User unblocked successfully!";
    }
}

// Get all users
$users = mysqli_query($conn, "SELECT * FROM users ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <header class="dashboard-header">
                <h1>Manage Users</h1>
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
                <div class="table-card">
                    <h2>All Users</h2>
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
                                    <th>Donor</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($user = mysqli_fetch_assoc($users)): ?>
                                    <tr>
                                        <td>#<?php echo $user['user_id']; ?></td>
                                        <td><?php echo $user['full_name']; ?></td>
                                        <td><?php echo $user['email']; ?></td>
                                        <td><?php echo $user['phone']; ?></td>
                                        <td><strong><?php echo $user['blood_group']; ?></strong></td>
                                        <td><?php echo $user['city']; ?></td>
                                        <td><?php echo $user['is_donor'] ? '✓' : '✗'; ?></td>
                                        <td>
                                            <?php if ($user['is_blocked']): ?>
                                                <span class="badge badge-rejected">Blocked</span>
                                            <?php else: ?>
                                                <span class="badge badge-approved">Active</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($user['is_blocked']): ?>
                                                <a href="?action=unblock&id=<?php echo $user['user_id']; ?>" class="btn btn-sm btn-success">Unblock</a>
                                            <?php else: ?>
                                                <a href="?action=block&id=<?php echo $user['user_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to block this user?')">Block</a>
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

