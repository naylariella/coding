<?php
session_start();
include 'koneksi.php';

// Kalau sudah login, langsung redirect
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Handle proses login jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'], $_POST['password'])) {
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['password'])) {
                // Login berhasil
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['username'] = $row['username'];
                header("Location: dashboard.php");
                exit();
            } else {
                $_SESSION['error'] = "Password salah!";
            }
        } else {
            $_SESSION['error'] = "Email tidak ditemukan!";
        }

        $stmt->close();
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error'] = "Mohon isi email dan password!";
        header("Location: login.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Login - Biblioffee</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #815942;
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    form {
      background: rgba(15, 15, 15, 0.9);
      padding: 25px 20px;
      border-radius: 10px;
      width: 320px;
      box-shadow: 0 0 10px #000;
      box-sizing: border-box;
    }
    h2 {
      margin-bottom: 20px;
      font-weight: 700;
      text-align: center;
    }
    label {
      display: block;
      margin-top: 12px;
      font-weight: 600;
    }
    input {
      width: 100%;
      padding: 10px;
      margin-top: 6px;
      border-radius: 5px;
      border: none;
      font-size: 1rem;
      box-sizing: border-box;
    }
    button {
      margin-top: 20px;
      width: 100%;
      padding: 12px;
      background-color: #a1565c;
      border: none;
      color: white;
      font-weight: bold;
      cursor: pointer;
      border-radius: 5px;
      font-size: 1.1rem;
      transition: background-color 0.3s ease;
    }
    button:hover {
      background-color:rgb(90, 12, 65);
    }
    .error {
      background-color: #ff6b6b;
      color: white;
      padding: 8px 12px;
      border-radius: 6px;
      margin-bottom: 15px;
      text-align: center;
      font-weight: 600;
    }
  </style>
</head>
<body>
  <form action="login.php" method="POST" autocomplete="off">
    <h2>Login Biblioffee</h2>
    <?php
      if (isset($_SESSION['error'])) {
        echo "<div class='error'>" . htmlspecialchars($_SESSION['error']) . "</div>";
        unset($_SESSION['error']);
      }
    ?>
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required autocomplete="username" />

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required autocomplete="current-password" />

    <button type="submit">Login</button>
  </form>
</body>
</html>
