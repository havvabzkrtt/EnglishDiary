<?php
require_once "config/db.php";
session_start();

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: login.php");
    exit;
}

// Bilinen kelimeleri çek
$known_sql = "SELECT fw.word_en, fw.meaning_tr 
              FROM user_known_words ukw 
              JOIN flashcards_words fw ON ukw.word_id = fw.id 
              WHERE ukw.user_id = ?";
$known_stmt = $conn->prepare($known_sql);
$known_stmt->bind_param("i", $user_id);
$known_stmt->execute();
$known_result = $known_stmt->get_result();
$known_words = $known_result->fetch_all(MYSQLI_ASSOC);

// Bilinmeyen kelimeleri çek
$unknown_sql = "SELECT fw.word_en, fw.meaning_tr 
                FROM user_unknown_words uuw 
                JOIN flashcards_words fw ON uuw.word_id = fw.id 
                WHERE uuw.user_id = ?";
$unknown_stmt = $conn->prepare($unknown_sql);
$unknown_stmt->bind_param("i", $user_id);
$unknown_stmt->execute();
$unknown_result = $unknown_stmt->get_result();
$unknown_words = $unknown_result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<?php $pageTitle = "Kelimelerim"; include('include/head.php'); ?>
<head>
  <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>

<?php include('include/navbar.php'); ?>

<main class="container py-5">
  <h1 class="text-center mb-4">Kelimelerim</h1>
  <div class="row">
    <!-- Bildiği Kelimeler -->
    <div class="col-md-6">
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white">
          Bildiğim Kelimeler
        </div>
        <ul class="list-group list-group-flush">
          <?php if (count($known_words) > 0): ?>
            <?php foreach ($known_words as $word): ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <strong><?= htmlspecialchars($word['word_en']) ?></strong>
                <span><?= htmlspecialchars($word['meaning_tr']) ?></span>
              </li>
            <?php endforeach; ?>
          <?php else: ?>
            <li class="list-group-item text-muted">Henüz bilinen kelime yok.</li>
          <?php endif; ?>
        </ul>
      </div>
    </div>

    <!-- Bilinmediği Kelimeler -->
    <div class="col-md-6">
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-danger text-white">
          Bilmediğim Kelimeler
        </div>
        <ul class="list-group list-group-flush">
          <?php if (count($unknown_words) > 0): ?>
            <?php foreach ($unknown_words as $word): ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <strong><?= htmlspecialchars($word['word_en']) ?></strong>
                <span><?= htmlspecialchars($word['meaning_tr']) ?></span>
              </li>
            <?php endforeach; ?>
          <?php else: ?>
            <li class="list-group-item text-muted">Henüz bilinmeyen kelime yok.</li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </div>
</main>

<?php include('include/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
