<?php
session_start();
header('Content-Type: application/json');
include("../config/db.php");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Giriş yapmalısınız.']);
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['word']) || !isset($_POST['reading_id'])) {
    echo json_encode(['success' => false, 'message' => 'Geçersiz istek.']);
    exit;
}

$word = strtolower(trim($_POST['word']));
$reading_id = intval($_POST['reading_id']);

// flashcards_words tablosundan kelimenin id'sini al
$stmt = $conn->prepare("SELECT id FROM flashcards_words WHERE word = ?");
$stmt->bind_param("s", $word);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    // Kelime yoksa ekle (opsiyonel)
    $stmt_insert = $conn->prepare("INSERT INTO flashcards_words (word) VALUES (?)");
    $stmt_insert->bind_param("s", $word);
    $stmt_insert->execute();
    $word_id = $stmt_insert->insert_id;
    $stmt_insert->close();
} else {
    $row = $res->fetch_assoc();
    $word_id = $row['id'];
}
$stmt->close();

// user_unknow_words tablosunda var mı kontrol et
$stmt2 = $conn->prepare("SELECT id FROM user_unknow_words WHERE user_id = ? AND word_id = ?");
$stmt2->bind_param("ii", $user_id, $word_id);
$stmt2->execute();
$res2 = $stmt2->get_result();

if ($res2->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Bu kelime zaten bilmiyorlar listenizde var.']);
    exit;
}
$stmt2->close();

// Ekle
$stmt3 = $conn->prepare("INSERT INTO user_unknow_words (user_id, word_id, added_at) VALUES (?, ?, NOW())");
$stmt3->bind_param("ii", $user_id, $word_id);
if ($stmt3->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Veritabanına eklenirken hata oluştu.']);
}
$stmt3->close();
$conn->close();
