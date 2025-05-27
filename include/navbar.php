<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="index.php">
      <img src="assets/images/logo.png" alt="Logo" width="30" height="30" class="me-2">
      <strong>EnglishDiary</strong>
    </a>

    <div class="d-flex align-items-center ms-auto">
      <?php if (isset($_SESSION['user_id'])): ?>
        <a href="flashcards.php" class="btn btn-outline-primary me-2">Kelime Kartları</a>
        <a href="quizs.php" class="btn btn-outline-secondary me-3">Quizler</a>

        <div class="dropdown">
          <a class="btn dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
            <img src="assets/images/default_pp.png" width="32" height="32" class="rounded-circle">
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="profile.php">Profilim</a></li>
            <li><a class="dropdown-item" href="settings.php">Ayarlar</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="logout.php">Çıkış Yap</a></li>
          </ul>
        </div>
      <?php else: ?>
        <a href="flashcards.php" class="btn btn-outline-primary me-2">Kelime Kartları</a>
        <a href="quizs.php" class="btn btn-outline-secondary me-3">Quizler</a>
        <a href="login.php" class="btn btn-primary">Giriş Yap</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
