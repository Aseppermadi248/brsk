<?php
include __DIR__ . '/includes/connection.php';

// Fetch about data from the database
$sql = "SELECT * FROM about LIMIT 1";
$result = $conn->query($sql);
$about_data = null;
if ($result->num_rows > 0) {
    $about_data = $result->fetch_assoc();
}
$conn->close();

include 'includes/header.php';
?>

<div class="container my-5">
 <section id="about" class="py-5">
 <div class="row align-items-center">
 <div class="col-md-6">
 <?php if ($about_data && $about_data['image']): ?>
 <img src="/brsk_store/assets/images/<?php echo htmlspecialchars($about_data['image']); ?>" class="img-fluid rounded" alt="About Us">
 <?php endif; ?>
 </div>
 <div class="col-md-6">
 <h2 class="mb-4">About BRSK STORE</h2>
 <p class="lead"><?php echo $about_data ? htmlspecialchars($about_data['content']) : 'Content about the store will be displayed here.'; ?></p>
 </div>
 </div>
 </section>
</div>
<?php include 'includes/footer.php'; ?>