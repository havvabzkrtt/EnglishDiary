<?php
session_start();
require_once "config/db.php";

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
  header("Location: login.php");
  exit;
}

$feedback = null; // Geri bildirim mesajı için

// Seviye yoksa varsayılan olarak A1
if (!isset($_SESSION['quiz_level'])) {
  $_SESSION['quiz_level'] = 'A1';
}
$level = $_SESSION['quiz_level'];

// Seviye seçimi veya cevap gönderimi kontrolü
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
  // Seviye seçilmişse güncelle
  if (isset($_POST['level'])) {
    $_SESSION['quiz_level'] = $_POST['level'];
    $level = $_POST['level'];
  }

  // Cevap gönderilmişse kontrol et ve yanlışları kaydet
  if (isset($_POST['answer']) && isset($_POST['question_id'])) {
    $qid = $_POST['question_id'];
    $user_answer = $_POST['answer'];

    $stmt = $conn->prepare("SELECT correct_option, topic FROM grammar_quiz_questions WHERE id = ?");
    $stmt->bind_param("i", $qid);
    $stmt->execute();
    $stmt->bind_result($correct_option, $topic);
    $stmt->fetch();
    $stmt->close();

    if ($user_answer !== $correct_option) {
      // Yanlış cevap verildi, user_wrong_grammar_topics tablosuna kaydet
      $stmt = $conn->prepare("INSERT INTO user_wrong_grammar_topics (user_id, question_id, topic) VALUES (?, ?, ?)");
      $stmt->bind_param("iis", $user_id, $qid, $topic);
      $stmt->execute();
      $stmt->close();

      $feedback = "<div class='alert alert-danger'>Yanlış cevap! Doğru cevap: <strong>$correct_option</strong>. Konu: $topic</div>";
    } else {
      $feedback = "<div class='alert alert-success'>Tebrikler! Doğru cevap verdiniz.</div>";
    }
  }
}

// Rastgele 1 soru çek
$stmt = $conn->prepare("SELECT id, question_text, option_a, option_b, option_c, option_d FROM grammar_quiz_questions WHERE level = ? ORDER BY RAND() LIMIT 1");
$stmt->bind_param("s", $level);
$stmt->execute();
$stmt->bind_result($current_question_id, $qtext, $a, $b, $c, $d);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="tr">
<?php $pageTitle = "Ana Sayfa"; include('include/head.php'); ?>
<head>
  <link rel="stylesheet" href="assets/styles.css"> <!-- Sticky footer için -->
</head>
<body>

<?php include('include/navbar.php'); ?>
<main>

<div class="container mt-5">
  <div class="card p-4 shadow-sm">

    <!-- Geri bildirim mesajı -->
    <?php if ($feedback): ?>
      <?= $feedback ?>
    <?php endif; ?>

    <form method="POST" class="mb-3">
      <label for="level" class="form-label">Seviye Seçin:</label>
      <select class="form-select mb-3" name="level" onchange="this.form.submit()">
        <?php foreach (['A1', 'A2', 'B1', 'B2', 'C1', 'C2'] as $lvl): ?>
          <option value="<?= $lvl ?>" <?= $level == $lvl ? 'selected' : '' ?>><?= $lvl ?></option>
        <?php endforeach; ?>
      </select>
    </form>

    <h5 class="mb-4">Soru:</h5>
    <p><strong><?= htmlspecialchars($qtext) ?></strong></p>

    <form method="POST">
      <input type="hidden" name="question_id" value="<?= $current_question_id ?>">

      <div class="form-check">
        <input class="form-check-input" type="radio" name="answer" id="a" value="A" required>
        <label class="form-check-label" for="a"><?= htmlspecialchars($a) ?></label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="answer" id="b" value="B">
        <label class="form-check-label" for="b"><?= htmlspecialchars($b) ?></label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="answer" id="c" value="C">
        <label class="form-check-label" for="c"><?= htmlspecialchars($c) ?></label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="answer" id="d" value="D">
        <label class="form-check-label" for="d"><?= htmlspecialchars($d) ?></label>
      </div>

      <button class="btn btn-primary mt-3" type="submit">Cevabı Gönder</button>
    </form>

  </div>
</div>
</main>

<?php include 'include/footer.php'; ?>
