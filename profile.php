<?php
session_start();
require_once('config/db.php');

// Giriş yapılmamışsa login sayfasına yönlendir
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Kullanıcının bilgilerini veritabanından çek
$user_id = $_SESSION['user_id'];

$sql = "SELECT username, email, created_at FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Eğer veritabanında kullanıcı bulunduysa, session içine yaz
if ($user) {
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['created_at'] = $user['created_at'];
}
?>
<!DOCTYPE html>
<html lang="tr">
<?php $pageTitle = "Profilim"; include('include/head.php'); ?>
<head>
  <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
<?php include('include/navbar.php'); ?>

<main class="container py-5">
  <h2>Profilim</h2>
  <div class="card mb-4 p-4">
    <div class="d-flex align-items-center">
      <img src="/assets/images/default_pp.png" width="64" height="64" class="rounded-circle me-3">
      <div>
        <h5><?php echo htmlspecialchars($_SESSION['username']); ?></h5>
        <p class="text-muted"><?php echo htmlspecialchars($_SESSION['email']); ?></p>
        <p>Kayıt Tarihi: <?php echo substr($_SESSION['created_at'], 0, 10); ?></p>
      </div>
    </div>
  </div>

  <div class="card p-4">
    <h5>İstatistikler</h5>
    <ul>
      <li>Toplam Kelime Sayısı: X</li>
      <li>Çözülmüş Quiz Sayısı: Y</li>
      <li>Başarı Oranı: %Z</li>
    </ul>
  </div>
</main>

<?php include('include/footer.php'); ?>
</body>
</html>
