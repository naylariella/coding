<?php
header('Content-Type: application/json');

// Konfigurasi database
$host = 'localhost';
$db   = 'biblioffee_a';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// Koneksi PDO
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

// Fungsi buatan untuk simpan review
function simpanReview($pdo, $rating, $review) {
    if ($rating >= 1 && $rating <= 5 && !empty(trim($review))) {
        $stmt = $pdo->prepare("INSERT INTO ratings (rating, review) VALUES (?, ?)");
        $stmt->execute([$rating, $review]);
        return ['success' => true];
    } else {
        return ['success' => false, 'message' => 'Data tidak valid'];
    }
}

try {
  $pdo = new PDO($dsn, $user, $pass, $options);

  $input = json_decode(file_get_contents("php://input"), true);
  $rating = (int)$input['rating'];
  $review = trim($input['review']);

  $result = simpanReview($pdo, $rating, $review);
  echo json_encode($result);

} catch (Exception $e) {
  echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
