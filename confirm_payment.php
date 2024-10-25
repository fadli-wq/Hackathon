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

// Di sini, Anda bisa mengupdate status pesanan, menandai sebagai telah dibayar, dll.
// Misalnya, jika Anda ingin mengupdate status di tabel orders, lakukan seperti ini:

// Contoh query untuk memperbarui status
$update_query = "UPDATE orders SET status = 'paid' WHERE user_id = ?";
$stmt = $conn->prepare($update_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();

// Redirect ke halaman konfirmasi pembayaran
header("Location: payment_success.php"); // Ganti dengan halaman konfirmasi pembayaran
exit();

$stmt->close();
$conn->close();
?>
