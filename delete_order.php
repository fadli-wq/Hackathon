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

// Ambil id dari query string
if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    // Hapus pesanan dari database
    $delete_query = "DELETE FROM orders WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $order_id);
    
    if ($stmt->execute()) {
        // Pesanan berhasil dihapus, redirect ke halaman orders dengan pesan sukses
        header("Location: orders.php?message=Order deleted successfully"); // Ganti dengan nama file halaman orders Anda
        exit();
    } else {
        // Jika terjadi kesalahan, redirect dengan pesan error
        header("Location: orders.php?message=Error deleting order");
        exit();
    }
} else {
    // Jika id tidak ditemukan, redirect dengan pesan error
    header("Location: orders.php?message=Invalid order ID");
    exit();
}

$stmt->close();
$conn->close();
?>
