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

// Respond to feedback
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $feedback_id = (int)$_POST['feedback_id'];
    $response = mysqli_real_escape_string($conn, $_POST['response']);
    $status = $_POST['status'];
    
    $query = "UPDATE feedback SET admin_response = '$response', status = '$status' WHERE feedback_id = $feedback_id";
    if (mysqli_query($conn, $query)) {
        $success = "Response submitted successfully!";
    } else {
        $error = "Failed to submit response!";
    }
}

// Get all feedback
$feedback_list = mysqli_query($conn, "SELECT * FROM feedback ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Feedback - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <header class="dashboard-header">
                <h1>Manage Feedback</h1>
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
                    <h2>All Feedback & Complaints</h2>
                    <div class="table-container">
                        <?php while ($feedback = mysqli_fetch_assoc($feedback_list)): ?>
                            <div class="feedback-item">
                                <div class="feedback-header">
                                    <h3><?php echo $feedback['subject']; ?></h3>
                                    <span class="badge badge-<?php echo strtolower($feedback['status']); ?>"><?php echo $feedback['status']; ?></span>
                                </div>
                                <div class="feedback-meta">
                                    <span>From: <?php echo $feedback['sender_type']; ?> #<?php echo $feedback['sender_id']; ?></span>
                                    <span>Date: <?php echo date('F d, Y', strtotime($feedback['created_at'])); ?></span>
                                </div>
                                <div class="feedback-message">
                                    <strong>Message:</strong>
                                    <p><?php echo nl2br($feedback['message']); ?></p>
                                </div>
                                
                                <?php if ($feedback['admin_response']): ?>
                                    <div class="admin-response">
                                        <strong>Admin Response:</strong>
                                        <p><?php echo nl2br($feedback['admin_response']); ?></p>
                                    </div>
                                <?php endif; ?>
                                
                                <form method="POST" action="" class="response-form">
                                    <input type="hidden" name="feedback_id" value="<?php echo $feedback['feedback_id']; ?>">
                                    <div class="form-group">
                                        <label>Response:</label>
                                        <textarea name="response" rows="3" required><?php echo $feedback['admin_response']; ?></textarea>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label>Status:</label>
                                            <select name="status">
                                                <option value="Pending" <?php echo $feedback['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                                <option value="Reviewed" <?php echo $feedback['status'] == 'Reviewed' ? 'selected' : ''; ?>>Reviewed</option>
                                                <option value="Resolved" <?php echo $feedback['status'] == 'Resolved' ? 'selected' : ''; ?>>Resolved</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Submit Response</button>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

