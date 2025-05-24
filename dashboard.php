<?php
session_start();

// 1. String
$namaPengguna = "Pelanggan Biblioffee";

// 2. Integer
$jumlahKopi = 6; // Sesuai jumlah data kopi

// 3a. Indexed Array
$kopiFavorit = ["Espresso", "Cappuccino", "Latte", "Americano", "Mocha", "Caramel Macchiato"];

// Cek apakah user sudah login berdasarkan session 'email' (sama dengan login.php)
if (!isset($_SESSION['email'])) {
    // Kalau belum login, redirect ke halaman login
    header('Location: login_form.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Biblioffee - Dashboard</title>
  <link href="https://fonts.cdnfonts.com/css/poppins" rel="stylesheet" />
  <style>
    /* --- CSS kamu tetap sama --- */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }
    body {
      background: #815942;
      color: #fff;
      min-height: 100vh;
      padding: 20px;
    }
    header {
      background-color: rgba(88, 82, 53, 0.9);
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      user-select: none;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 100;
      font-weight: bold;
      font-size: 1.4rem;
    }
    header .logo {
      color: #fff;
    }
    .cart-icon {
      position: relative;
      cursor: pointer;
    }
    .cart-count {
      position: absolute;
      top: -8px;
      right: -10px;
      background: red;
      color: white;
      border-radius: 50%;
      font-size: 0.75rem;
      padding: 2px 6px;
    }
    main {
      margin-top: 80px;
      max-width: 900px;
      margin-left: auto;
      margin-right: auto;
    }
    h1 {
      margin-bottom: 30px;
      text-align: center;
      font-size: 2.5rem;
      color: #c8f1d7;
      text-shadow: 0 0 10px #01020ef1;
    }
    .coffee-list {
      display: grid;
      grid-template-columns: repeat(auto-fill,minmax(250px,1fr));
      gap: 25px;
    }
    .coffee-card {
      background: rgba(255 255 255 / 0.1);
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 0 15px rgba(78, 129, 105, 0.9);
      transition: transform 0.3s ease;
      cursor: default;
      position: relative;
    }
    .coffee-card:hover {
      transform: scale(1.05);
      box-shadow: 0 0 20px #a8a26a;
    }
    .coffee-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      display: block;
      pointer-events: none;
    }
    .coffee-info {
      padding: 15px 20px;
    }
    .coffee-info h3 {
      font-size: 1.3rem;
      margin-bottom: 8px;
      color: #d9f7d9;
    }
    .coffee-info p {
      font-size: 1rem;
      color: #0c0c0c;
      margin-bottom: 12px;
    }
    .coffee-info .price {
      font-weight: 700;
      font-size: 1.1rem;
      color: #0a0a0a;
    }
    .add-button {
      position: absolute;
      bottom: 15px;
      right: 15px;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background-color: #a1565c;
      color: white;
      border: none;
      font-size: 1.4em;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    .add-button:hover {
      background-color: #9c8394;
    }
    .toast {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background: rgba(28, 29, 29, 0.9);
      color: white;
      padding: 10px 20px;
      border-radius: 6px;
      opacity: 0;
      transition: all 0.4s ease;
      z-index: 999;
    }
    .toast.show {
      opacity: 1;
      bottom: 40px;
    }
    .logout-btn {
      background: #c94f4f;
      color: white;
      padding: 6px 12px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 600;
      font-size: 0.9rem;
      transition: background-color 0.3s ease;
    }
    .logout-btn:hover {
      background-color: #a83f3f;
    }
  </style>
</head>
<body>
  <header>
      <div class="logo">BIBLIOFFEE</div>
      <div>
        <a href="keranjang.html" class="cart-icon" id="cartIcon">
          🛒 <span class="cart-count" id="cartCount">0</span>
        </a>
        &nbsp;&nbsp;
        <a href="logout.php" class="logout-btn">Logout</a>
      </div>
  </header>      
  <main>
    <h1>Daftar Kopi Favorit</h1>
    <div class="coffee-list" id="coffeeList"></div>
  </main>
  <div class="toast" id="toast">Kopi ditambahkan ke keranjang!</div>

  <script>
    const coffeeData = [
      {
        name: "Espresso",
        price: 15000,
        description: "Kopi hitam pekat dengan rasa kuat dan aroma tajam.",
        img: "https://i.imgur.com/mNk4jqN.png"
      },
      {
        name: "Cappuccino",
        price: 20000,
        description: "Kopi dengan busa susu lembut dan cita rasa creamy.",
        img: "https://i.imgur.com/Sv3fvpz.png"
      },
      {
        name: "Latte",
        price: 22000,
        description: "Kopi dengan campuran susu panas yang lembut dan manis.",
        img: "https://i.imgur.com/Kk01TGR.png"
      },
      {
        name: "Americano",
        price: 18000,
        description: "Kopi hitam yang lebih encer dengan rasa halus dan ringan.",
        img: "https://i.imgur.com/P1i86NO.png"
      },
      {
        name: "Mocha",
        price: 25000,
        description: "Kopi dengan campuran cokelat manis dan susu yang lezat.",
        img: "https://i.imgur.com/WFSRQhO.png"
      },
      {
        name: "Caramel Macchiato",
        price: 27000,
        description: "Kopi creamy dengan lapisan karamel manis di atasnya.",
        img: "https://i.imgur.com/V6tbmCm.png"
      }
    ];

    const cartKey = 'kopiCart';
    const cartCount = document.getElementById('cartCount');
    const coffeeList = document.getElementById('coffeeList');
    const toast = document.getElementById('toast');

    function loadCart() {
      const cart = JSON.parse(localStorage.getItem(cartKey)) || [];
      cartCount.textContent = cart.length;
    }

    function showToast(message) {
      toast.textContent = message;
      toast.classList.add('show');
      setTimeout(() => {
        toast.classList.remove('show');
      }, 2000);
    }

    function addToCart(item) {
      const cart = JSON.parse(localStorage.getItem(cartKey)) || [];
      cart.push(item);
      localStorage.setItem(cartKey, JSON.stringify(cart));
      loadCart();
      showToast(`${item.name} ditambahkan ke keranjang!`);
    }

    function renderCoffees() {
      coffeeData.forEach(coffee => {
        const div = document.createElement('div');
        div.className = 'coffee-card';
        div.innerHTML = `
          <img src="${coffee.img}" alt="${coffee.name}" />
          <div class="coffee-info">
            <h3>${coffee.name}</h3>
            <p>${coffee.description}</p>
            <div class="price">Rp ${coffee.price.toLocaleString('id-ID')}</div>
          </div>
          <button class="add-button">+</button>
        `;
        const btn = div.querySelector('.add-button');
        btn.addEventListener('click', () => addToCart(coffee));
        coffeeList.appendChild(div);
      });
    }

    document.addEventListener('DOMContentLoaded', () => {
      loadCart();
      renderCoffees();
    });
  </script>
</body>
</html>
