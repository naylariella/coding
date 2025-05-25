<?php
session_start();

// Kalau user sudah login (cek session user_id), langsung redirect ke dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
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
      user-select: none;
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
      user-select: none;
    }
    button:hover {
      background-color:rgb(80, 9, 57);
    }
    .error {
      background-color: #ff6b6b;
      color: white;
      padding: 8px 12px;
      border-radius: 6px;
      margin-bottom: 15px;
      text-align: center;
      font-weight: 600;
      user-select: none;
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
