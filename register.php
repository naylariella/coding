<?php
include 'koneksi.php';

$username = $_POST['username'];
$email    = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

if (!empty($username) && !empty($email) && !empty($_POST['password'])) {
    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    if ($conn->query($sql)) {
        echo "Registrasi berhasil!";
    } else {
        echo "Email sudah terdaftar.";
    }
} else {
    echo "Semua field harus diisi!";
}
?>
