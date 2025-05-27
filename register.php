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
<head>
  <meta charset="UTF-8">
  <title>Kayıt Ol - EnglishDiary</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include('include/navbar.php'); ?>

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

<?php include('include/footer.php'); ?>
</body>
</html>
