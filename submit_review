<?php
// submit_review.php
header('Content-Type: application/json');

$host = 'localhost'; // atau IP server database
$db   = 'biblioffee_a';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
  $pdo = new PDO($dsn, $user, $pass, $options);

  $input = json_decode(file_get_contents("php://input"), true);
  $rating = (int)$input['rating'];
  $review = trim($input['review']);

  if ($rating >= 1 && $rating <= 5 && !empty($review)) {
    $stmt = $pdo->prepare("INSERT INTO ratings (rating, review) VALUES (?, ?)");
    $stmt->execute([$rating, $review]);
    echo json_encode(['success' => true]);
  } else {
    echo json_encode(['success' => false, 'message' => 'Data tidak valid']);
  }

} catch (Exception $e) {
  echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
