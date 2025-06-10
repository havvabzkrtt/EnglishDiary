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
  <link rel="stylesheet" href="styles.css">
</head>
<body>


<?php include('../include/navbar.php'); ?>

<div class="wrapper">
<main class="container">
  <div class="reading-detail">
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
</main>

<script>
document.querySelectorAll('.word').forEach(function(span){
    span.addEventListener('click', function(){
        var word = this.dataset.word;
        var el = this;
        fetch('add_unknown_word.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'word=' + encodeURIComponent(word) + '&reading_id=<?= $reading_id ?>'
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                el.classList.add('clicked');
                alert(`"${word}" kelimesi bilmiyorlar listesine eklendi.`);
            } else {
                alert(data.message);
            }
        })
        .catch(() => alert("Bir hata oluştu."));
    });
});
</script>

<?php include('../include/footer.php'); ?>
</div>
</body>

