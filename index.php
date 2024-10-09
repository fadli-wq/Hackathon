<?php
// Database connection
$host = 'localhost';
$dbname = 'hackathon';
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
    <link rel="stylesheet" href="produk.css">
</head>
<body>

<div class="container">
    <h1>Marketplace</h1>

    <!-- Categories and products -->
    <?php while ($category = $category_result->fetch_assoc()): ?>
        <h2><?php echo $category['category_name']; ?></h2>
        
        <div class="product-grid">
            <?php
            // Fetch products for the category
            $product_query = "SELECT * FROM products WHERE category_id=" . $category['id'];
            $product_result = $conn->query($product_query);

            while ($product = $product_result->fetch_assoc()):
            ?>
            <div class="product-card">
                <img src="<?php echo $product['product_image']; ?>" alt="<?php echo $product['product_name']; ?>" width="200" height="200">
                <h3><?php echo $product['product_name']; ?></h3>
                <p><?php echo $product['product_description']; ?></p>
                <p>Price: Rp <?php echo number_format($product['product_price']); ?></p>
                <a href="buy.php?product_id=<?php echo $product['id']; ?>" class="btn">Buy Now</a>
            </div>
            <?php endwhile; ?>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>
