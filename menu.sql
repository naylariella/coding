CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL
);




INSERT INTO `menu` (`id`, `nama_menu`, `harga`, `deskripsi`, `gambar`) VALUES
(1, 'Espresso', 15000, 'Kopi hitam pekat dengan rasa kuat dan aroma tajam', 'https://i.imgur.com/mNk4jqN.png'),
(2, 'Cappuccino', 20000, 'Kopi dengan busa susu lembut dan cita rasa creamy', 'https://i.imgur.com/Sv3fvpz.png'),
(3, 'Latte', 22000, 'Kopi dengan campuran susu panas yang lembut dan manis', 'https://i.imgur.com/Kk01TGR.png'),
(4, 'Americano', 18000, 'Kopi hitam yang lebih encer dengan rasa halus dan ringan', 'https://i.imgur.com/P1i86NO.png'),
(5, 'Mocha', 25000, 'Kopi dengan campuran cokelat manis dan susu yang lezat', 'https://i.imgur.com/WFSRQhO.png'),
(6, 'Caramel Macchiato', 27000, 'Kopi creamy dengan lapisan karamel manis di atasnya', 'https://i.imgur.com/V6tbmCm.png');
