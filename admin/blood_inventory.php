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

// Update inventory
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inventory_id = (int)$_POST['inventory_id'];
    $units = (int)$_POST['units'];
    
    mysqli_query($conn, "UPDATE blood_inventory SET units_available = $units WHERE inventory_id = $inventory_id");
    $success = "Inventory updated successfully!";
}

// Get all inventory
$inventory = mysqli_query($conn, "SELECT bi.*, bb.name as blood_bank_name, bb.city 
                                  FROM blood_inventory bi 
                                  JOIN blood_banks bb ON bi.blood_bank_id = bb.blood_bank_id 
                                  ORDER BY bb.city, bb.name, bi.blood_group");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Inventory - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <header class="dashboard-header">
                <h1>Blood Inventory Management</h1>
                <div class="user-info">
                    <a href="../logout.php" class="btn btn-logout">Logout</a>
                </div>
            </header>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <div class="content-wrapper">
                <div class="table-card">
                    <h2>Current Blood Inventory</h2>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Blood Bank</th>
                                    <th>City</th>
                                    <th>Blood Group</th>
                                    <th>Units Available</th>
                                    <th>Last Updated</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($item = mysqli_fetch_assoc($inventory)): ?>
                                    <tr>
                                        <td><?php echo $item['blood_bank_name']; ?></td>
                                        <td><?php echo $item['city']; ?></td>
                                        <td><strong><?php echo $item['blood_group']; ?></strong></td>
                                        <td>
                                            <span class="badge <?php echo $item['units_available'] > 10 ? 'badge-approved' : ($item['units_available'] > 5 ? 'badge-pending' : 'badge-rejected'); ?>">
                                                <?php echo $item['units_available']; ?> units
                                            </span>
                                        </td>
                                        <td><?php echo date('M d, Y H:i', strtotime($item['last_updated'])); ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" onclick="editInventory(<?php echo $item['inventory_id']; ?>, <?php echo $item['units_available']; ?>)">Edit</button>
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
    
    <div id="editModal" class="modal">
        <div class="modal-content">
            <h2>Update Inventory</h2>
            <form method="POST" action="">
                <input type="hidden" name="inventory_id" id="edit_inventory_id">
                <div class="form-group">
                    <label>Units Available:</label>
                    <input type="number" name="units" id="edit_units" min="0" required>
                </div>
                <div class="modal-actions">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function editInventory(id, units) {
            document.getElementById('edit_inventory_id').value = id;
            document.getElementById('edit_units').value = units;
            document.getElementById('editModal').style.display = 'flex';
        }
        
        function closeModal() {
            document.getElementById('editModal').style.display = 'none';
        }
    </script>
</body>
</html>

