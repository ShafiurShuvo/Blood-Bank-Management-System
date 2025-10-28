<?php
require_once '../config/session.php';
require_once '../config/db_connect.php';

requireLogin();
if (!isAdmin()) {
    header("Location: ../login.php");
    exit();
}

// Get statistics
$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users"))['count'];
$total_donors = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users WHERE is_donor = 1"))['count'];
$total_hospitals = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM hospitals"))['count'];
$total_blood_banks = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM blood_banks"))['count'];
$total_donations = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM blood_donations"))['count'];
$total_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM blood_orders"))['count'];
$pending_donations = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM blood_donations WHERE status = 'Pending'"))['count'];
$pending_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM blood_orders WHERE status = 'Pending'"))['count'];

// Get recent activity
$recent_users = mysqli_query($conn, "SELECT * FROM users ORDER BY created_at DESC LIMIT 5");
$recent_donations = mysqli_query($conn, "SELECT bd.*, u.full_name, bb.name as blood_bank_name 
                                         FROM blood_donations bd 
                                         JOIN users u ON bd.donor_id = u.user_id 
                                         JOIN blood_banks bb ON bd.blood_bank_id = bb.blood_bank_id 
                                         ORDER BY bd.created_at DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Blood Bank</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <header class="dashboard-header">
                <h1>Admin Dashboard</h1>
                <div class="user-info">
                    <span>Welcome, Admin</span>
                    <a href="../logout.php" class="btn btn-logout">Logout</a>
                </div>
            </header>
            
            <div class="dashboard-stats">
                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <div class="stat-details">
                        <h3><?php echo $total_users; ?></h3>
                        <p>Total Users</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">🩸</div>
                    <div class="stat-details">
                        <h3><?php echo $total_donors; ?></h3>
                        <p>Active Donors</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">🏥</div>
                    <div class="stat-details">
                        <h3><?php echo $total_hospitals; ?></h3>
                        <p>Hospitals</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">🏦</div>
                    <div class="stat-details">
                        <h3><?php echo $total_blood_banks; ?></h3>
                        <p>Blood Banks</p>
                    </div>
                </div>
            </div>
            
            <div class="dashboard-stats">
                <div class="stat-card">
                    <div class="stat-icon">💉</div>
                    <div class="stat-details">
                        <h3><?php echo $total_donations; ?></h3>
                        <p>Total Donations</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">📋</div>
                    <div class="stat-details">
                        <h3><?php echo $total_orders; ?></h3>
                        <p>Total Orders</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">⏳</div>
                    <div class="stat-details">
                        <h3><?php echo $pending_donations; ?></h3>
                        <p>Pending Donations</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">⏱️</div>
                    <div class="stat-details">
                        <h3><?php echo $pending_orders; ?></h3>
                        <p>Pending Orders</p>
                    </div>
                </div>
            </div>
            
            <div class="dashboard-content">
                <div class="content-section">
                    <h2>Recent User Registrations</h2>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Blood Group</th>
                                    <th>City</th>
                                    <th>Donor</th>
                                    <th>Registered</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($user = mysqli_fetch_assoc($recent_users)): ?>
                                    <tr>
                                        <td><?php echo $user['full_name']; ?></td>
                                        <td><?php echo $user['email']; ?></td>
                                        <td><strong><?php echo $user['blood_group']; ?></strong></td>
                                        <td><?php echo $user['city']; ?></td>
                                        <td><?php echo $user['is_donor'] ? '✓' : '✗'; ?></td>
                                        <td><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="content-section">
                    <h2>Recent Donations</h2>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Donor</th>
                                    <th>Blood Bank</th>
                                    <th>Blood Group</th>
                                    <th>Units</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($donation = mysqli_fetch_assoc($recent_donations)): ?>
                                    <tr>
                                        <td><?php echo $donation['full_name']; ?></td>
                                        <td><?php echo $donation['blood_bank_name']; ?></td>
                                        <td><strong><?php echo $donation['blood_group']; ?></strong></td>
                                        <td><?php echo $donation['units']; ?></td>
                                        <td><?php echo date('M d, Y', strtotime($donation['donation_date'])); ?></td>
                                        <td><span class="badge badge-<?php echo strtolower($donation['status']); ?>"><?php echo $donation['status']; ?></span></td>
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

