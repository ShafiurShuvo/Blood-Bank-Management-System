<?php 
require_once 'config/session.php';

// Redirect to dashboard if already logged in
if (isLoggedIn()) {
    redirectToDashboard();
}

// Include the static HTML content
include 'index.html';
?>
