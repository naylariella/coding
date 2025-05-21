<?php
session_start();
header('Content-Type: application/json');

include 'koneksi.php'; // pastikan file ini berisi koneksi $conn ke MySQL

// Cek user login
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Silakan login terlebih dahulu']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil data JSON dari request body (fetch POST)
$data = json_decode(file_get_contents('php://input'), true);

// Validasi data
if (!$data || empty($data['items'])) {
    echo json_encode(['error' => 'Data pesanan kosong atau tidak valid']);
    exit;
}

$items = $data['items'];
$success = true;
$conn->begin_transaction();

try {
    // Loop tiap item, simpan ke DB
    $stmt = $conn->prepare("INSERT INTO riwayat_pesan (user_id, nama_menu, harga, jumlah, total) VALUES (?, ?, ?, ?, ?)");

    foreach ($items as $item) {
        $nama_menu = $item['name'];
        $harga = intval($item['price']);
        $jumlah = intval($item['quantity']);
        $total = $harga * $jumlah;

        $stmt->bind_param("isiii", $user_id, $nama_menu, $harga, $jumlah, $total);
        if (!$stmt->execute()) {
            throw new Exception("Gagal menyimpan item: $nama_menu");
        }
    }

    $conn->commit();
    echo json_encode(['success' => 'Pesanan berhasil disimpan']);
} catch (Exception $e) {
    $conn->rollback();
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
