<?php
session_start();
// Check if the admin is logged in, otherwise redirect to the login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php");
    exit();
}
include 'includes/header_admin.php';
?>

<div class="container mt-5" style="padding-top: 5rem;">
    <h2 class="text-center">Admin Dashboard</h2>
    <p class="text-center">Welcome to the admin area. You can manage the website content from here.</p>
</div>

<?php include 'includes/footer_admin.php'; ?>
