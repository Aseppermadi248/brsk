<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: /brsk_store/admin/index.php');
    exit;
}
?>
<?php include '/brsk_store/admin/includes/header_admin.php'; ?>

<div class="container-fluid py-4">
    <h2>Welcome to the Admin Dashboard</h2>
</div>

<?php include('/brsk_store/admin/includes/footer_admin.php'); ?>
