<?php
require_once '../config/session.php';
require_once '../config/db_connect.php';

requireLogin();
if (!isHospital()) {
    header("Location: ../login.php");
    exit();
}

$hospital_id = $_SESSION['hospital_id'];
$success = '';
$error = '';

// Submit feedback
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    $query = "INSERT INTO feedback (sender_type, sender_id, subject, message) 
              VALUES ('Hospital', $hospital_id, '$subject', '$message')";
    
    if (mysqli_query($conn, $query)) {
        $success = "Feedback submitted successfully!";
    } else {
        $error = "Failed to submit feedback!";
    }
}

// Get hospital's feedback history
$feedback_list = mysqli_query($conn, "SELECT * FROM feedback 
                                      WHERE sender_type = 'Hospital' AND sender_id = $hospital_id 
                                      ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback - Hospital</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <header class="dashboard-header">
                <h1>Feedback & Complaints</h1>
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
                <div class="form-card">
                    <h2>Submit Feedback</h2>
                    <form method="POST" action="" class="feedback-form">
                        <div class="form-group">
                            <label for="subject">Subject:</label>
                            <input type="text" name="subject" id="subject" placeholder="Enter subject" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Message:</label>
                            <textarea name="message" id="message" rows="6" placeholder="Write your feedback or complaint here..." required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Submit Feedback</button>
                    </form>
                </div>
                
                <div class="table-card">
                    <h2>Feedback History</h2>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Message</th>
                                    <th>Status</th>
                                    <th>Admin Response</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($feedback_list) > 0): ?>
                                    <?php while ($feedback = mysqli_fetch_assoc($feedback_list)): ?>
                                        <tr>
                                            <td><?php echo $feedback['subject']; ?></td>
                                            <td><?php echo substr($feedback['message'], 0, 50) . '...'; ?></td>
                                            <td><span class="badge badge-<?php echo strtolower($feedback['status']); ?>"><?php echo $feedback['status']; ?></span></td>
                                            <td><?php echo $feedback['admin_response'] ? substr($feedback['admin_response'], 0, 50) . '...' : 'No response yet'; ?></td>
                                            <td><?php echo date('M d, Y', strtotime($feedback['created_at'])); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No feedback submitted yet</td>
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

