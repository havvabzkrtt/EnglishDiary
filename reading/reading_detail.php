<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['user_id'])) {
    die("Lütfen giriş yapınız.");
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Geçersiz parça ID'si.");
}

$reading_id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM reading_texts WHERE id = ?");
$stmt->bind_param("i", $reading_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Parça bulunamadı.");
}

$reading = $result->fetch_assoc();
$content = htmlspecialchars($reading['content']);
$words = preg_split('/(\s+|\b)/u', $content, -1, PREG_SPLIT_DELIM_CAPTURE);
?>

<!DOCTYPE html>
<html lang="tr">
<?php $pageTitle = "Okuma Parçası"; include('../include/head.php'); ?>
<head>
  <link rel="stylesheet" href="../assets/styles.css">
  <style>
    body, html {
      height: 100%;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    .wrapper {
      flex: 1 0 auto;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    .center-container {
      flex: 1 0 auto;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 70vh;
    }
    .reading-box {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 2px 12px rgba(0,0,0,0.08);
      padding: 32px 24px;
      max-width: 700px;
      width: 100%;
    }
    .reading-text {
      font-size: 1.25rem; /* Yazı boyutunu büyüttük */
      color: #111;        /* Yazı rengini siyah yaptık */
      line-height: 1.8;
    }
    .word {
      color: #111;
      font-weight: 500;
      padding: 0;
      border-radius: 0;
      cursor: default;
      background: none;
      transition: none;
    }
    footer {
      flex-shrink: 0;
      width: 100%;
      margin-top: auto;
    }
  </style>
</head>
<body>

<?php include('../include/navbar.php'); ?>

<div class="wrapper">
  <div class="center-container">
    <div class="reading-box">
      <h2><?= htmlspecialchars($reading['title']) ?></h2>
      <p><strong>Seviye:</strong> <?= $reading['level'] ?></p>

      <div id="reading-content" class="reading-text">
        <?php
        foreach ($words as $w) {
            if (preg_match('/^\w+$/u', $w)) {
                echo '<span class="word" data-word="' . strtolower($w) . '">' . $w . '</span>';
            } else {
                echo $w;
            }
        }
        ?>
      </div>
    </div>
  </div>
  <?php include('../include/footer.php'); ?>
</div>

</body>
</html>