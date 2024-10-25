<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // Redirect ke halaman login jika user_id tidak ada di sesi
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Ambil user_id dari sesi

// Database connection
$host = 'localhost';
$dbname = 'marketplace';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$product_id = $_GET['product_id'];

// Fetch product details
$product_query = "SELECT * FROM products WHERE id = $product_id";
$product_result = $conn->query($product_query);
$product = $product_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Product</title>
    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
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
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container my-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <img src="<?php echo 'images/' . $product['product_image']; ?>" class="card-img-top" alt="<?php echo $product['product_name']; ?>">
                <div class="card-body">
                    <h3 class="card-title"><?php echo $product['product_name']; ?></h3>
                    <p class="card-text">
                        <?php echo $product['product_description']; ?>
                    </p>
                    <h4 class="text-muted">Price: Rp <?php echo number_format($product['product_price'], 2, ',', '.'); ?></h4>

                    <!-- Quantity Input -->
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1" required>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="checkout.php?product_id=<?php echo $product['id']; ?>&quantity=" id="checkoutLink" class="btn btn-success btn-lg">Proceed to Checkout</a>
                        <a href="marketplace.php" class="btn btn-outline-secondary">Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-light text-center py-3">
    <p>&copy; 2024 Marketplace. All Rights Reserved.</p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Update the checkout link with the selected quantity
    document.getElementById('quantity').addEventListener('input', function() {
        const quantity = this.value;
        const checkoutLink = document.getElementById('checkoutLink');
        checkoutLink.href = `checkout.php?product_id=<?php echo $product['id']; ?>&quantity=${quantity}`;
    });
</script>

</body>
</html>
