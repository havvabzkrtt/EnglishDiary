<?php
session_start();
require_once("config/db.php");

if (!isset($_SESSION['user_id'])) {
  header("Location: /login.php");
  exit();
}

$success = "";
$error = "";
$user_id = $_SESSION["user_id"];

// Şifre Güncelleme
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update_password"])) {
  $current = $_POST["current_password"];
  $new = $_POST["new_password"];
  $confirm = $_POST["confirm_password"];

  if (!empty($current) && !empty($new) && $new === $confirm) {
    $stmt = $conn->prepare("SELECT password_hash FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hash);
    $stmt->fetch();
    $stmt->close();

    if (password_verify($current, $hash)) {
      $new_hash = password_hash($new, PASSWORD_DEFAULT);
      $stmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
      $stmt->bind_param("si", $new_hash, $user_id);
      if ($stmt->execute()) {
        $success = "Şifreniz başarıyla güncellendi.";
      } else {
        $error = "Şifre güncellenemedi.";
      }
      $stmt->close();
    } else {
      $error = "Mevcut şifreniz yanlış.";
    }
  } else {
    $error = "Tüm alanları doğru doldurduğunuzdan emin olun.";
  }
}

// Hesap Silme (E-posta + Şifre doğrulama)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_account"])) {
  $email_input = trim($_POST["delete_email"]);
  $password_input = $_POST["delete_password"];

  if (!empty($email_input) && !empty($password_input)) {
    $stmt = $conn->prepare("SELECT email, password_hash FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($stored_email, $stored_hash);
    $stmt->fetch();
    $stmt->close();

    if ($email_input === $stored_email && password_verify($password_input, $stored_hash)) {
      $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
      $stmt->bind_param("i", $user_id);
      $stmt->execute();
      $stmt->close();
      session_destroy();
      header("Location: goodbye.php");
      exit();
    } else {
      $error = "E-posta veya şifre hatalı.";
    }
  } else {
    $error = "Lütfen e-posta ve şifre alanlarını doldurun.";
  }
}
?>

<!DOCTYPE html>
<html lang="tr">
<?php $pageTitle = "Ayarlar"; include('include/head.php'); ?>
<head>
  <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
<?php include('include/navbar.php'); ?>

<main class="container py-5">
  <h2>Hesap Ayarları</h2>

  <?php if ($success): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
  <?php endif; ?>
  <?php if ($error): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
  <?php endif; ?>

  <!-- Şifre Güncelle -->
  <form method="post" class="mb-4">
    <h5>Şifre Değiştir</h5>
    <div class="mb-2">
      <input type="password" name="current_password" class="form-control" placeholder="Mevcut Şifre" required>
    </div>
    <div class="mb-2">
      <input type="password" name="new_password" class="form-control" placeholder="Yeni Şifre" required>
    </div>
    <div class="mb-3">
      <input type="password" name="confirm_password" class="form-control" placeholder="Yeni Şifre (Tekrar)" required>
    </div>
    <button type="submit" name="update_password" class="btn btn-warning">Şifreyi Güncelle</button>
  </form>

  <!-- Hesap Sil -->
  <form method="post">
    <h5 class="text-danger">Hesabı Kalıcı Olarak Sil</h5>
    <div class="mb-2">
      <input type="email" name="delete_email" class="form-control" placeholder="E-posta adresinizi girin" required>
    </div>
    <div class="mb-3">
      <input type="password" name="delete_password" class="form-control" placeholder="Şifrenizi girin" required>
    </div>
    <button type="submit" name="delete_account" class="btn btn-danger"
      onclick="return confirm('Hesabınızı kalıcı olarak silmek istediğinizden emin misiniz?')">
      Hesabımı Sil
    </button>
  </form>
</main>

<?php include('include/footer.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
