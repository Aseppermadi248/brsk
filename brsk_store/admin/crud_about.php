<?php
session_start();
// Check if the admin is logged in, otherwise redirect to the login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

include_once '../includes/connection.php';

// Fetch existing about data
$sql = "SELECT * FROM about LIMIT 1";
$about_data = null;
if ($result = $conn->query($sql)) {
    if ($result->num_rows > 0) {
        $about_data = $result->fetch_assoc();
    }
    $result->free();
}

$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['content'];
    $image_path = $about_data['image_path'] ?? ''; // Keep existing image path by default

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../assets/images/"; // Corrected relative path
        $target_file = $target_dir . basename($_FILES["image"]["name"]);

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Use a relative path from the project root for the DB
                $image_path = 'assets/images/' . basename($_FILES["image"]["name"]);
            } else {
                $message = "Sorry, there was an error uploading your file.";
            }
        } else {
            $message = "File is not an image.";
        }
    }

    if (empty($message)) {
        // Update the database
        $sql = "UPDATE about SET content = ?, image_path = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $content, $image_path);

        if ($stmt->execute()) {
            $message = "About Us content updated successfully!";
            // Re-fetch data to display updated content
            $sql = "SELECT * FROM about LIMIT 1";
            $result = $conn->query($sql);
            $about_data = $result->fetch_assoc();
        } else {
            $message = "Error updating record: " . $conn->error;
        }
        $stmt->close();
    }
}
?>

<?php include_once 'includes/header_admin.php'; ?>

<main class="container mt-4">
    <h2 class="mb-4">Edit About Us</h2>

    <?php if ($message): ?>
        <div class="alert alert-info" role="alert">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form action="crud_about.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="10" required><?php echo htmlspecialchars($about_data['content'] ?? ''); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <?php if (!empty($about_data['image_path'])): ?>
                <div class="mb-2">
                    <img src="../<?php echo $about_data['image_path']; ?>" alt="Current About Image" class="img-thumbnail" style="max-width: 200px;">
                    <p class="mt-2">Current Image: <?php echo basename($about_data['image_path']); ?></p>
                </div>
            <?php endif; ?>
            <input class="form-control" type="file" id="image" name="image" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Update About Us</button>
    </form>
</main>

<?php
$conn->close();
include_once 'includes/footer_admin.php';
?>
