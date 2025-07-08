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
    

   
    <?php include 'includes/footer.php'; ?>
</body>
</html>
