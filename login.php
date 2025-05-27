<?php
require_once "config/db.php";

session_start();
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, username, password_hash FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit();
        } else {
            $message = "Şifre yanlış.";
        }
    } else {
        $message = "Kullanıcı bulunamadı.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Giriş Yap - EnglishDiary</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include('include/navbar.php'); ?>

<div class="container mt-5">
  <h2 class="mb-4">Giriş Yap</h2>
  <?php if ($message): ?>
    <div class="alert alert-danger"><?= $message ?></div>
  <?php endif; ?>
  <form method="POST">
    <div class="mb-3">
      <label>E-posta</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Şifre</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button class="btn btn-primary">Giriş Yap</button>
    <p class="mt-3">Hesabınız yok mu? <a href="register.php">Kayıt Ol</a></p>
  </form>
</div>

<?php include('include/footer.php'); ?>
</body>
</html>
