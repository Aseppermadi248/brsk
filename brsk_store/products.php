<?php include './includes/connection.php'; ?>
<?php include './includes/header.php'; ?>

<div class="container mt-5" style="padding-top: 5rem;">
    <h2 class="text-center mb-4">Our Products</h2>
    <div class="row">
        <?php
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);


        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="assets/images/<?php echo $row['image']; ?>" class="card-img-top" alt="<?php echo $row['name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['name']; ?></h5>
                            <p class="card-text"><?php echo $row['description']; ?></p>
                        </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p class='text-center'>No products found.</p>";
        }
        ?>

<?php
$conn->close();
?>

<?php include 'includes/footer.php'; ?>
