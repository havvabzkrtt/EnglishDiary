<nav class="navbar navbar-expand-lg bg-dark">
  <div class="container">
    <a class="navbar-brand text-white" href="/index.php">
      <img src="/assets/images/logo.png" alt="Logo" width="30" height="30" class="me-2">
      <strong>EnglishDiary</strong>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" 
      aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav ms-auto align-items-center">
        <?php if (isset($_SESSION['user_id'])): ?>
          <li class="nav-item">
            <a class="nav-link text-white" href="/wordlist.php">Kelimelerim</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="/quizs.php">Quizlerim</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>

    <?php if (isset($_SESSION['user_id'])): ?>
      <div class="d-flex align-items-center">
        <div class="dropdown ms-2">
          <a class="btn dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">
            <img src="/assets/images/default_pp.png" width="32" height="32" class="rounded-circle">
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="/profile.php">Profilim</a></li>
            <li><a class="dropdown-item" href="/settings.php">Ayarlar</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="/logout.php">Çıkış Yap</a></li>

          </ul>
        </div>
      </div>
    <?php endif; ?>
  </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
