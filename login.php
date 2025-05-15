<?php
session_start();

// Koneksi ke database MySQL
$host = "localhost";
$user = "root";  // sesuaikan dengan user database kamu
$password = "";  // password database, kosong kalau belum diatur
$dbname = "nama_database";  // ganti dengan nama database kamu

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form login
$username = $_POST['username'];
$password = $_POST['password'];

// Query cek username dan password di database
$sql = "SELECT * FROM users WHERE username = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    // Cek password (asumsikan password di DB sudah di-hash, kalau belum tinggal cocokkan langsung)
    if (password_verify($password, $user['password'])) {
        // Login sukses, simpan session
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php"); // halaman setelah login
        exit();
    } else {
        // Password salah
        header("Location: login.html?error=Password salah");
        exit();
    }
} else {
    // Username tidak ditemukan
    header("Location: login.html?error=Username tidak ditemukan");
    exit();
}

$stmt->close();
$conn->close();
?>
