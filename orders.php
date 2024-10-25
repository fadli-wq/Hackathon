<?php
// Mulai sesi
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

// Ambil user_id dari sesi
if (!isset($_SESSION['user_id'])) {
    // Redirect ke halaman login jika user_id tidak ada di sesi
    header("Location: login.php"); // Ganti dengan halaman login Anda
    exit();
}

$user_id = $_SESSION['user_id']; // Ambil user_id dari sesi

// Fetch orders for the user
$order_query = "SELECT orders.*, products.product_name, products.product_image, users.name AS user_name
                FROM orders
                JOIN products ON orders.product_id = products.id
                JOIN users ON orders.user_id = users.id
                WHERE orders.user_id = ?";
$stmt = $conn->prepare($order_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$order_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders</title>
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
                    <a class="nav-link" href="#">Orders</a>
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
    <h1 class="text-center">Your Orders</h1>

    <?php if (isset($_GET['message'])): ?>
    <div class="alert alert-info text-center" role="alert">
        <?php echo htmlspecialchars($_GET['message']); ?>
    </div>
<?php endif; ?>
    <?php if ($order_result->num_rows > 0): ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php while ($order = $order_result->fetch_assoc()): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="<?php echo 'images/' . $order['product_image']; ?>" alt="<?php echo $order['product_name']; ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $order['product_name']; ?></h5>
                            <p class="text-muted">Quantity: <?php echo $order['quantity']; ?></p>
                            <p class="text-muted">Total Price: Rp <?php echo number_format($order['total_price'], 2, ',', '.'); ?></p>
                            <p class="text-muted">Ordered on: <?php echo date('d M Y', strtotime($order['order_date'])); ?></p>
                            <a href="delete_order.php?id=<?php echo $order['id']; ?>" class="btn btn-danger">Delete</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="text-center my-4">
            <a href="payment.php" class="btn btn-success btn-lg">Proceed to Payment</a>
        </div>
    <?php else: ?>
        <p class="text-center">You have no orders yet.</p>
    <?php endif; ?>
</div>

<!-- Footer -->
<footer class="bg-dark text-light text-center py-4 mt-5">
    <p>&copy; 2024 Marketplace. All Rights Reserved.</p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>