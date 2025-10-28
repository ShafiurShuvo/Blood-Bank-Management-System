<?php
require_once '../config/session.php';
require_once '../config/db_connect.php';

requireLogin();
if (!isAdmin()) {
    header("Location: ../login.php");
    exit();
}

// Get all blood banks
$blood_banks = mysqli_query($conn, "SELECT * FROM blood_banks ORDER BY city, name");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blood Banks - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <header class="dashboard-header">
                <h1>Manage Blood Banks</h1>
                <div class="user-info">
                    <a href="../logout.php" class="btn btn-logout">Logout</a>
                </div>
            </header>
            
            <div class="content-wrapper">
                <div class="table-card">
                    <h2>All Blood Banks</h2>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($bank = mysqli_fetch_assoc($blood_banks)): ?>
                                    <tr>
                                        <td>#<?php echo $bank['blood_bank_id']; ?></td>
                                        <td><?php echo $bank['name']; ?></td>
                                        <td><?php echo $bank['city']; ?></td>
                                        <td><?php echo $bank['state']; ?></td>
                                        <td><?php echo $bank['phone']; ?></td>
                                        <td><?php echo $bank['email']; ?></td>
                                        <td><?php echo substr($bank['address'], 0, 50) . '...'; ?></td>
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

