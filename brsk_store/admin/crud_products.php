<?php
session_start();
// Check if the admin is logged in, otherwise redirect to the login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

include_once '../includes/connection.php';

$message = "";

// Handle product deletion
if (isset($_GET['delete'])) {
    $id_to_delete = $_GET['delete'];
    // First, get the image path to delete the file
    $stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
    $stmt->bind_param("i", $id_to_delete);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $product = $result->fetch_assoc();
        $image_file_path = '../' . $product['image']; // Path from admin folder to root and then to assets
        if (file_exists($image_file_path)) {
            unlink($image_file_path);
        }
    }
    $stmt->close();

    // Now, delete the record from the database
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id_to_delete);
    if ($stmt->execute()) {
        $message = "Product deleted successfully.";
    } else {
        $message = "Error deleting product.";
    }
    $stmt->close();
}


// Handle form submission for adding a new product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $image_path = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../assets/images/"; // Relative path from admin folder
        $image_name = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = 'assets/images/' . $image_name; // Path to store in DB (relative from root)
        } else {
            $message = "Sorry, there was an error uploading your file.";
        }
    }

    if (empty($message)) {
        $stmt = $conn->prepare("INSERT INTO products (name, description, image) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $description, $image_path);
        if ($stmt->execute()) {
            $message = "New product added successfully.";
        } else {
            $message = "Error adding product: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch all products to display
$products = [];
$sql = "SELECT * FROM products ORDER BY id DESC";
if ($result = $conn->query($sql)) {
    $products = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();
}

?>
<?php include_once 'includes/header_admin.php'; ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Manage Products</h2>

    <?php if ($message): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>

    <!-- Add Product Form -->
    <div class="card mb-4">
        <div class="card-header">
            Add New Product
        </div>
        <div class="card-body">
            <form action="crud_products.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Product Image</label>
                    <input class="form-control" type="file" id="image" name="image" required>
                </div>
                <button type="submit" name="add_product" class="btn btn-primary">Add Product</button>
            </form>
        </div>
    </div>

    <!-- Products List -->
    <div class="card">
        <div class="card-header">
            Existing Products
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($products)): ?>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($product['id']); ?></td>
                                    <td><img src="../<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" width="50"></td>
                                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                                    <td><?php echo htmlspecialchars($product['description']); ?></td>
                                    <td>
                                        <!-- Note: Edit functionality would require a separate edit form/page -->
                                        <!-- <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-warning">Edit</a> -->
                                        <a href="crud_products.php?delete=<?php echo $product['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No products found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
$conn->close();
include_once 'includes/footer_admin.php';
?>
