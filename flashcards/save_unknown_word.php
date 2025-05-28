<?php
session_start();
include('../config/db.php');


header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Giriş yapmalısınız']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$word_id = $data['word_id'] ?? null;

if (!$word_id) {
    echo json_encode(['success' => false, 'message' => 'Kelime ID gerekli']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Önce aynı kaydın varlığını kontrol et (tekrar kaydetmesin)
$stmt = $conn->prepare("SELECT id FROM user_unknown_words WHERE user_id = ? AND word_id = ?");
$stmt->bind_param("ii", $user_id, $word_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(['success' => true, 'message' => 'Kelime zaten kaydedilmiş']);
    exit;
}
$stmt->close();

// Yeni kayıt ekle
$stmt = $conn->prepare("INSERT INTO user_unknown_words (user_id, word_id, added_at) VALUES (?, ?, NOW())");
$stmt->bind_param("ii", $user_id, $word_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Kelime kaydedildi']);
} else {
    echo json_encode(['success' => false, 'message' => 'Veritabanı hatası']);
}

$stmt->close();
$conn->close();
