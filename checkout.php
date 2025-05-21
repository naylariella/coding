<?php
session_start();
header('Content-Type: application/json');

// Cek login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Anda harus login dulu']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil data JSON POST
$data = json_decode(file_get_contents('php://input'), true);
if (!$data || !isset($data['cart']) || !is_array($data['cart'])) {
    echo json_encode(['success' => false, 'message' => 'Data keranjang tidak valid']);
    exit;
}

$cart = $data['cart'];

// Koneksi database (ubah sesuai config kamu)
$host = "localhost";
$user = "root";
$pass = "";
$db   = "biblioffee_a";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Koneksi database gagal: ' . $conn->connect_error]);
    exit;
}

// Prepare statement insert ke riwayat_pesan
$stmt = $conn->prepare("INSERT INTO riwayat_pesan (user_id, nama_menu, harga, jumlah, total) VALUES (?, ?, ?, ?, ?)");

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Prepare statement gagal: ' . $conn->error]);
    exit;
}

foreach ($cart as $item) {
    // Validasi data minimal
    if (!isset($item['name'], $item['price'])) {
        continue; // skip jika data kurang lengkap
    }

    $nama_menu = $item['name'];
    $harga = (int)$item['price'];
    $jumlah = 1; // karena keranjang kamu saat ini belum ada input jumlah, default 1
    $total = $harga * $jumlah;

    $stmt->bind_param("isiii", $user_id, $nama_menu, $harga, $jumlah, $total);
    $stmt->execute();
}

$stmt->close();
$conn->close();

echo json_encode(['success' => true]);
