<?php
require_once "config/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password_hash);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        $message = "Kayıt başarısız: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<?php $pageTitle = "Giriş Sayfa"; include('include/head.php'); ?>
<head>
  <link rel="stylesheet" href="/assets/styles.css"> <!-- Sticky footer için -->
</head>
<body>

<?php include('include/navbar.php'); ?>

<main>
<div class="container mt-5">
  <h2 class="mb-4">Kayıt Ol</h2>
  <?php if ($message): ?>
    <div class="alert alert-danger"><?= $message ?></div>
  <?php endif; ?>
  <form method="POST">
    <div class="mb-3">
      <label>Kullanıcı Adı</label>
      <input type="text" name="username" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>E-posta</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Şifre</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button class="btn btn-primary">Kayıt Ol</button>
    <p class="mt-3">Zaten hesabınız var mı? <a href="login.php">Giriş Yap</a></p>
  </form>
</div>
  </main>
  
<?php include('include/footer.php'); ?>

