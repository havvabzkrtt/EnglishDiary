<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

$selected_level = $_GET['level'] ?? '';
$levels = ['A0', 'A1', 'A2', 'B1', 'B2', 'C1', 'C2'];
if (!in_array($selected_level, $levels)) {
    $selected_level = '';
}
?>

<!DOCTYPE html>
<html lang="tr">
<?php $pageTitle = "Okuma Parçaları"; include('../include/head.php'); ?>
<head>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php include('../include/navbar.php'); ?>
<div class="wrapper">
<main class="container">
  <h2 class="section-title">Okuma Parçaları</h2>

  <form method="GET" action="" class="level-form">
    <label for="level">Seviye seçin:</label>
    <select name="level" id="level" onchange="this.form.submit()">
      <option value="">-- Hepsi --</option>
      <?php foreach ($levels as $level): ?>
        <option value="<?= $level ?>" <?= $selected_level === $level ? 'selected' : '' ?>><?= $level ?></option>
      <?php endforeach; ?>
    </select>
  </form>

  <div class="card-grid">
    <?php
    $sql = "SELECT * FROM reading_texts";
    if ($selected_level) {
        $sql .= " WHERE level = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $selected_level);
    } else {
        $stmt = $conn->prepare($sql);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0):
        while ($row = $result->fetch_assoc()):
    ?>
      <div class="reading-card">
        <h3><a href="reading_detail.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['title']) ?></a></h3>
        <p><strong>Seviye:</strong> <?= $row['level'] ?></p>
      </div>
    <?php endwhile; else: ?>
      <p>Hiç parça bulunamadı.</p>
    <?php endif; $conn->close(); ?>
  </div>
</main>

<?php include('../include/footer.php'); ?>

    </div>
</body>
</html>
