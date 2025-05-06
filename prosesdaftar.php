<?php
function tampilkanData($nama, $usia, $email, $tipe) {
    echo "<h2> ✅ Pendaftaran Berhasil!</h2>";
    echo "Nama: $nama<br>";
    echo "Usia: $usia tahun<br>";
    echo "Email: $email<br>";
    echo "Keanggotaan: $tipe<br>";
}

if (isset($_POST["nama"])) {
}
// Ambil dan sanitasi input
    $nama = htmlspecialchars(trim($_POST["nama"]));
    $usia = isset($_POST["usia"]) ? (int)$_POST["usia"] : 0;
    $email = isset($_POST["email"]) ? htmlspecialchars(trim($_POST["email"])) : '';
    $tipe = isset($_POST["tipe"]) ? htmlspecialchars($_POST["tipe"]) : '';

// Validasi semua field diisi
if (empty($nama) || empty($usia) || empty($email) || empty($tipe)) {
    echo "<p style='color:red;'> Semua field wajib diisi.</p>";
    exit;
}

// Validasi email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<p style='color:red;'> Alamat email tidak valid.</p>";
    exit;
}

// Validasi usia vs tipe keanggotaan
if ((int)$usia < 17 && $tipe != "Pelajar") {
    echo "<p style='color:orange;'> Tipe keanggotaan tidak sesuai dengan usia. Anggota di bawah 17 tahun seharusnya memilih 'Pelajar'.</p>";
}

// Jika semua valid, tampilkan data
tampilkanData($nama, $usia, $email, $tipe);
?>
