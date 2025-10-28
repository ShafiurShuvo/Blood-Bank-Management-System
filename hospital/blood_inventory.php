<?php
require_once '../config/session.php';
require_once '../config/db_connect.php';

requireLogin();
if (!isHospital()) {
    header("Location: ../login.php");
    exit();
}

// Get blood inventory from all blood banks
$inventory = mysqli_query($conn, "SELECT bb.name as blood_bank_name, bb.city, bb.state, 
                                   bi.blood_group, bi.units_available, bi.last_updated
                                   FROM blood_inventory bi
                                   JOIN blood_banks bb ON bi.blood_bank_id = bb.blood_bank_id
                                   ORDER BY bb.city, bb.name, bi.blood_group");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Inventory - Hospital</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <header class="dashboard-header">
                <h1>Blood Inventory</h1>
                <div class="user-info">
                    <a href="../logout.php" class="btn btn-logout">Logout</a>
                </div>
            </header>
            
            <div class="content-wrapper">
                <div class="table-card">
                    <h2>Available Blood Units</h2>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Blood Bank</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Blood Group</th>
                                    <th>Units Available</th>
                                    <th>Last Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($inventory) > 0): ?>
                                    <?php while ($item = mysqli_fetch_assoc($inventory)): ?>
                                        <tr>
                                            <td><?php echo $item['blood_bank_name']; ?></td>
                                            <td><?php echo $item['city']; ?></td>
                                            <td><?php echo $item['state']; ?></td>
                                            <td><strong><?php echo $item['blood_group']; ?></strong></td>
                                            <td>
                                                <span class="badge <?php echo $item['units_available'] > 10 ? 'badge-approved' : ($item['units_available'] > 5 ? 'badge-pending' : 'badge-rejected'); ?>">
                                                    <?php echo $item['units_available']; ?> units
                                                </span>
                                            </td>
                                            <td><?php echo date('M d, Y H:i', strtotime($item['last_updated'])); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No inventory data available</td>
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

