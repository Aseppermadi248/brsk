<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {

    header('Location: /brsk_store/admin/index.php');
    exit();
}

include_once '/brsk_store/includes/connection.php';
// Include necessary header
include_once '/brsk_store/admin/includes/header_admin.php';

$message = '';

// Handle Add Product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $target_dir = '/brsk_store/assets/images/';
    $target_file = $target_dir . basename($image);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (!isset($_FILES['image']['tmp_name']) || !is_uploaded_file($_FILES['image']['tmp_name'])) {
        $message = "No file uploaded or invalid file.";
        $uploadOk = 0;
    } else {
 $check = getimagesize($_FILES['image']['tmp_name']);
    }

    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $message = "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES['image']['size'] > 5000000) { // 5MB
        $message = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $sql = "INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssds", $name, $description, $price, $image);

            if ($stmt->execute()) {
                $message = "New product added successfully.";
            } else {
                $message = "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $message = "Sorry, there was an error uploading your file.";
        }
    }
}

// Handle Delete Product
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Optional: Delete the image file as well
        // Fetch the image filename before deleting the record
        $sql_get_image = "SELECT image FROM products WHERE id = ?";
        $stmt_get_image = $conn->prepare($sql_get_image);
        $stmt_get_image->bind_param("i", $id);
        $stmt_get_image->execute();
        $stmt_get_image->bind_result($image_filename);
        $stmt_get_image->fetch();
        $stmt_get_image->close();

        unlink('/brsk_store/assets/images/' . $image_filename); // Delete the image file
        $message = "Product deleted successfully.";
    } else {
        $message = "Error deleting product: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch Products for display
$sql = "SELECT * FROM products ORDER BY id DESC"; // Order by ID for consistency
$result = $conn->query($sql);
?>

<div class="container mt-4">
    <h2>Manage Products</h2>

    <?php if ($message): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>

    <div class="card mb-4">
 <div class="card-header">
            <h3>Add New Product</h3>
        </div>
 <div class="card-body">
 <form action="" method="post" enctype="multipart/form-data">
 <div class="mb-3">
 <label for="name" class="form-label">Product Name</label>
 <input type="text" class="form-control" id="name" name="name" required>
 </div>
 <div class="mb-3">
 <label for="description" class="form-label">Description</label>
 <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
 </div>
 <div class="mb-3">
 <label for="price" class="form-label">Price</label>
 <input type="number" class="form-control" id="price" name="price" step="0.01" required>
 </div>
 <div class="mb-3">
 <label for="image" class="form-label">Product Image</label>
 <input type="file" class="form-control" id="image" name="image" required>
 </div>
 <button type="submit" name="add_product" class="btn btn-primary">Add Product</button>
 </form>
 </div>
    </div>

    <div class="card">
 <div class="card-header">
            <h3>Existing Products</h3>
        </div>
 <div class="card-body">
 <div class="table-responsive">
 <table class="table table-striped table-bordered">
 <thead>
 <tr>
 <th>ID</th>
 <th>Name</th>
 <th>Price</th>
 <th>Image</th>
 <th>Actions</th>
 </tr>
 </thead>
 <tbody>
 <?php
            if ($result->num_rows > 0) {
 // Loop through each product and display it in a table row
 while ($row = $result->fetch_assoc()) {
 echo "<tr>";
 echo "<td>" . $row['id'] . "</td>";
 echo "<td>" . $row['name'] . "</td>";
 echo "<td>" . $row['price'] . "</td>";
 echo "<td><img src='/brsk_store/assets/images/" . $row['image'] . "' alt='" . $row['name'] . "' width='50'></td>";
 echo "<td>\n";
 echo "<a href='/brsk_store/admin/edit_product.php?id=" . $row['id'] . "' class='btn btn-sm btn-warning me-2'>Edit</a>";
 echo "<a href='/brsk_store/admin/crud_products.php?delete=" . $row['id'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this product?\")'>Delete</a>";
 echo "</td>";
 echo "</tr>";
                }
            } else {
 echo "<tr><td colspan='5' class='text-center'>No products found.</td></tr>";
            }
 ?>
 </tbody>
 </table>
 </div>
 </div>
        </div>
</div>

<?php // Include the necessary footer ?>
<?php
$conn->close();
include_once '/brsk_store/admin/includes/footer_admin.php';
?>
