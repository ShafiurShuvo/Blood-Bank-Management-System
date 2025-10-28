<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']) || isset($_SESSION['hospital_id']) || isset($_SESSION['admin_id']);
}

// Check if user is admin
function isAdmin() {
    return isset($_SESSION['admin_id']);
}

// Check if user is regular user
function isUser() {
    return isset($_SESSION['user_id']);
}

// Check if user is hospital
function isHospital() {
    return isset($_SESSION['hospital_id']);
}

// Get current user type
function getUserType() {
    if (isset($_SESSION['admin_id'])) return 'admin';
    if (isset($_SESSION['user_id'])) return 'user';
    if (isset($_SESSION['hospital_id'])) return 'hospital';
    return null;
}

// Redirect to login if not authenticated
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

// Redirect to appropriate dashboard based on user type
function redirectToDashboard() {
    if (isAdmin()) {
        header("Location: admin/dashboard.php");
    } elseif (isUser()) {
        header("Location: user/dashboard.php");
    } elseif (isHospital()) {
        header("Location: hospital/dashboard.php");
    }
    exit();
}
?>

