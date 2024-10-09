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
</head>
<body>

<h1>Buy <?php echo $product['product_name']; ?></h1>
<p>Price: Rp <?php echo number_format($product['product_price']); ?></p>

<!-- You can add more checkout details here -->

<a href="checkout.php?product_id=<?php echo $product['id']; ?>">Proceed to Checkout</a>

</body>
</html>
