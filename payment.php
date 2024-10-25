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
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch orders for the user
$order_query = "SELECT orders.*, products.product_name, products.product_image
                FROM orders
                JOIN products ON orders.product_id = products.id
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
    <title>Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<div class="container my-5">
    <h1 class="text-center">Payment Details</h1>

    <?php if ($order_result->num_rows > 0): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total_amount = 0; // Inisialisasi total
                while ($order = $order_result->fetch_assoc()): 
                    $total_amount += $order['total_price'];
                ?>
                    <tr>
                        <td><?php echo $order['product_name']; ?></td>
                        <td><?php echo $order['quantity']; ?></td>
                        <td>Rp <?php echo number_format($order['total_price'], 2, ',', '.'); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <h3>Total Amount: Rp <?php echo number_format($total_amount, 2, ',', '.'); ?></h3>
        <a href="confirm_payment.php" class="btn btn-success">Confirm Payment</a>
    <?php else: ?>
        <p class="text-center">You have no orders to pay for.</p>
    <?php endif; ?>
</div>

<footer class="bg-dark text-light text-center py-4 mt-5">
    <p>&copy; 2024 Marketplace. All Rights Reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
