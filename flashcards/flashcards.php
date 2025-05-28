<?php
session_start();
include('../config/db.php');

// Kullanıcı giriş kontrolü
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Seçilen seviye (GET ile veya default 'A0')
$level = $_GET['level'] ?? 'A0';

// Geçerli seviyeler (güvenlik için)
$valid_levels = ['A0', 'A1', 'B1', 'B2', 'C1', 'C2'];
if (!in_array($level, $valid_levels)) {
    $level = 'A0';
}

// Seçilen seviyeye göre kelimeleri çekiyoruz
$stmt = $conn->prepare("SELECT id, word_en, meaning_tr, example_en FROM flashcards_words WHERE level = ?");
$stmt->bind_param("s", $level);
$stmt->execute();
$result = $stmt->get_result();

$words = [];
while ($row = $result->fetch_assoc()) {
    $words[] = $row;
}
?>

<?php $pageTitle = "Flashcards - Kelime Kartları"; ?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <?php include('../include/head.php'); ?>
    <link rel="stylesheet" href="../assets/styles.css" />
</head>
<body>

<?php include('../include/navbar.php'); ?>

<main class="container py-5">

    <h1 class="mb-4 text-center">🎴 Kelime Kartları - Seviye: <?= htmlspecialchars($level) ?></h1>

    <!-- Seviye seçimi formu -->
    <form method="get" class="mb-4 text-center">
        <label for="level">Seviye seçiniz: </label>
        <select name="level" id="level" onchange="this.form.submit()">
            <?php foreach ($valid_levels as $lvl): ?>
                <option value="<?= $lvl ?>" <?= $lvl === $level ? 'selected' : '' ?>><?= $lvl ?></option>
            <?php endforeach; ?>
        </select>
    </form>

    <?php if (count($words) === 0): ?>
        <p class="text-center">Bu seviyede henüz kelime bulunmamaktadır.</p>
    <?php else: ?>
        <div class="flashcard-container text-center">
            <div class="flashcard" id="flashcard">
                <div class="front">
                    <h2 id="word-en"><?= htmlspecialchars($words[0]['word_en']) ?></h2>
                </div>
                <div class="back">
                    <p><strong>Türkçe:</strong> <span id="meaning-tr"><?= htmlspecialchars($words[0]['meaning_tr']) ?></span></p>
                    <p><strong>Örnek:</strong> <em id="example-en"><?= htmlspecialchars($words[0]['example_en']) ?></em></p>
                </div>
            </div>

            <div class="mt-3">
                <button type="button" id="know-btn" class="btn btn-outline-secondary">Biliyorum</button>
                <button type="button" id="dont-know-btn" class="btn btn-outline-secondary">Bilmiyorum</button>
            </div>
            <div class="mt-3">
            <button type="button" id="new-word-btn" class="btn btn-info">Yeni Kelime</button>
            </div>
            <p id="finish-message" class="text-center mt-3" style="color:green; font-weight:bold;"></p>
        
        </div>
    <?php endif; ?>

</main>

<?php include('../include/footer.php'); ?>

<script>
    const words = <?= json_encode($words) ?>;
</script>
<script src="flashcards_script.js"></script>

</body>
</html>
