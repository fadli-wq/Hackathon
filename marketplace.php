<?php
session_start();
// Database connection
$host = 'localhost';
$dbname = 'marketplace';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch categories
$category_query = "SELECT * FROM categories";
$category_result = $conn->query($category_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="produk.css">
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Marketplace</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Option 1: Dropdown Profile -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Welcome, <?= $_SESSION['user_name'] ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a href="login.php" class="btn btn-success">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>


<!-- Main Content -->
<div class="container my-5">
    <h1 class="text-center">Welcome to the Marketplace</h1>

    <!-- Categories and products -->
    <?php while ($category = $category_result->fetch_assoc()): ?>
        <h2 class="mt-5"><?php echo $category['category_name']; ?></h2>
        
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            // Fetch products for the category
            $product_query = "SELECT * FROM products WHERE category_id=" . $category['id'];
            $product_result = $conn->query($product_query);

            while ($product = $product_result->fetch_assoc()):
            ?>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="<?php echo 'images/'. $product['product_image']; ?>" alt="<?php echo $product['product_name']; ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product['product_name']; ?></h5>
                        <p class="card-text"><?php echo $product['product_description']; ?></p>
                        <p class="text-muted">Price: Rp <?php echo number_format($product['product_price']); ?></p>
                        <a href="<?php echo isset($_SESSION['user_name']) ? 'buy.php?product_id=' . $product['id'] : 'login.php'; ?>" class="btn btn-primary">Buy Now</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    <?php endwhile; ?>
</div>

<!-- Footer -->
<footer class="bg-dark text-light text-center py-4 mt-5">
    <p>&copy; 2024 Marketplace. All Rights Reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
