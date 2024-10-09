<?php
// Database connection
$host = 'localhost';
$dbname = 'marketplace';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data dari URL
$product_id = $_GET['product_id'];

// Simulasi user_id yang sedang login (untuk sementara, misalnya user_id 1)
$user_id = 1; // ganti sesuai logika login Anda

// Jumlah produk yang dibeli (bisa dinamis jika perlu)
$quantity = 1;

// Fetch product details
$product_query = "SELECT * FROM products WHERE id = $product_id";
$product_result = $conn->query($product_query);
$product = $product_result->fetch_assoc();

// Hitung total harga
$total_price = $product['product_price'] * $quantity;

// Simpan pesanan ke tabel orders
$order_query = "INSERT INTO orders (product_id, user_id, quantity, total_price) VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($order_query);
$stmt->bind_param("iiid", $product_id, $user_id, $quantity, $total_price);

if ($stmt->execute()) {
    $order_status = "Order successfully placed!";
} else {
    $order_status = "Error: " . $conn->error;
}

// Tutup koneksi
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
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
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="card-title mb-4">Order Confirmation</h2>
                    
                    <!-- Order Status Message -->
                    <p class="alert alert-success">
                        <?php echo $order_status; ?>
                    </p>

                    <!-- Product Details -->
                    <img src="<?php echo 'images/' . $product['product_image']; ?>" alt="<?php echo $product['product_name']; ?>" class="img-fluid mb-3" style="height: 200px; object-fit: cover;">
                    
                    <h3><?php echo $product['product_name']; ?></h3>
                    <p class="text-muted">Quantity: <?php echo $quantity; ?></p>
                    <p class="text-muted">Total Price: Rp <?php echo number_format($total_price); ?></p>

                    <!-- Back to Home or Continue Shopping -->
                    <div class="d-grid gap-2 mt-4">
                        <a href="index.php" class="btn btn-primary btn-lg">Continue Shopping</a>
                        <a href="orders.php" class="btn btn-outline-secondary">View Your Orders</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-light text-center py-4 mt-5">
    <p>&copy; 2024 Marketplace. All Rights Reserved.</p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
