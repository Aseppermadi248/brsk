<?php
ini_set('session.use_cookies', 1);
ini_set('session.cookie_httponly', 1);
session_name('BRSK_SESSION');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BRSK Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <div class="hero bg-primary text-white text-center py-5">
        <div class="container">
            <h1 class="display-4">Selamat Datang di BRSK</h1>
            <p class="lead">Temukan koleksi pakaian terbaik untuk gaya harian Anda.</p>
            <a href="about.php" class="btn btn-light btn-lg">Pelajari Lebih Lanjut</a>
        </div>
    </div>

    <!-- Promotion Section -->
    <div class="container my-5">
        <div class="row text-center">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-tags fa-3x mb-3"></i>
                        <h5 class="card-title">Diskon Spesial</h5>
                        <p class="card-text">Nikmati diskon hingga 50% untuk koleksi terbaru kami!</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-shipping-fast fa-3x mb-3"></i>
                        <h5 class="card-title">Pengiriman Cepat</h5>
                        <p class="card-text">Pengiriman cepat dan aman ke seluruh Indonesia.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-headset fa-3x mb-3"></i>
                        <h5 class="card-title">Layanan Pelanggan 24/7</h5>
                        <p class="card-text">Tim kami siap membantu Anda kapan saja.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Our Customers Section -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Our Customers</h2>
        <div class="row">
            <div class="col-md-4 text-center">
                <img src="https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e" alt="Customer 1" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px;">
                <h5>John Doe</h5>
                <p>"Koleksi BRSK selalu membuat saya tampil stylish!"</p>
            </div>
            <div class="col-md-4 text-center">
                <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9" alt="Customer 2" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px;">
                <h5>Jane Smith</h5>
                <p>"Pelayanan yang luar biasa dan produk berkualitas!"</p>
            </div>
            <div class="col-md-4 text-center">
                <img src="https://images.unsplash.com/photo-1506794778202-001f647a8c7d" alt="Customer 3" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px;">
                <h5>Michael Brown</h5>
                <p>"Saya selalu kembali untuk berbelanja di BRSK!"</p>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
