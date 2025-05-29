<?php session_start(); ?>
<!DOCTYPE html>
<html lang="tr">
<?php $pageTitle = "Ana Sayfa"; include('include/head.php'); ?>
<head>
  <link rel="stylesheet" href="assets/styles.css"> <!-- Sticky footer için -->
</head>
<body>

<?php include('include/navbar.php'); ?>

<main>
  <!-- Hero Alanı -->
  <section class="py-5 text-center custom-hero text-white">
    <div class="container">
      <h1 class="display-5 fw-bold">Learn Englısh the Smart Way!</h1>
      <p class="lead">Kelime öğren, yazı yaz, test çöz. Hepsi EnglishDiary ile tek yerde.</p>
      <?php if (!isset($_SESSION['user_id'])): ?>
        <a href="login.php" class="btn btn-light btn-lg mt-3">Hemen Başla</a>
      <?php endif; ?>
    </div>
  </section>

  <!-- Özellik Kartları -->
  <section class="py-5">
  <div class="container">
    <h2 class="text-center mb-4">Neler Sunuyoruz?</h2>
    <div class="row g-4">

      <!-- Herkese açık kart -->
      <!-- Kelime Oyunu kartı -->
      <div class="col-md-4">
        <a href="plays/word_play.php" class="text-decoration-none text-dark">
          <div class="card h-100 shadow-sm">
            <div class="card-body text-center">
              <h5 class="card-title">🎮 Kelime Oyunu</h5>
              <p class="card-text">Kelimeleri eğlenceli mini oyunlarla öğren ve pekiştir.</p>
            </div>
          </div>
        </a>
      </div>

      

      <!-- Giriş gerekli kart -->
      <div class="col-md-4">
        <?php if (isset($_SESSION['user_id'])): ?>
          <a href="flashcards/flashcards.php" class="text-decoration-none text-dark">
            <div class="card h-100 shadow-sm">
              <div class="card-body text-center">
                <h5 class="card-title">📘 Kelime Kartları</h5>
                <p class="card-text">Kendi kelime defterini oluştur ve tekrar et.</p>
              </div>
            </div>
          </a>
        <?php else: ?>
          <div class="card h-100 shadow-sm border-warning">
            <div class="card-body text-center">
              <h5 class="card-title">📘 Kelime Kartları</h5>
              <p class="card-text text-muted">Bu özelliği kullanmak için giriş yapmalısınız.</p>
              <a href="/login.php" class="btn btn-light btn-lg btn-sm">Giriş Yap</a>
            </div>
          </div>
        <?php endif; ?>
      </div>
      
      <div class="col-md-4">
        <?php if (isset($_SESSION['user_id'])): ?>
          <a href="quizs.php" class="text-decoration-none text-dark">
            <div class="card h-100 shadow-sm">
              <div class="card-body text-center">
                <h5 class="card-title">🧠 Mini Quizler</h5>
                <p class="card-text">Seviye bazlı testlerle bilginizi ölçün ve gelişiminizi takip edin.</p>
              </div>
            </div>
          </a>
        <?php else: ?>
          <div class="card h-100 shadow-sm border-warning">
            <div class="card-body text-center">
              <h5 class="card-title">🧠 Mini Quizler</h5>
              <p class="card-text text-muted">Bu özelliği kullanmak için giriş yapmalısınız.</p>
              <a href="login.php" class="btn btn-light btn-lg btn-sm">Giriş Yap</a>
            </div>
          </div>
        <?php endif; ?>
      </div>
      

      <!-- Giriş gerekli kart -->
      <div class="col-md-4">
        <?php if (isset($_SESSION['user_id'])): ?>
          <a href="diary.php" class="text-decoration-none text-dark">
            <div class="card h-100 shadow-sm">
              <div class="card-body text-center">
                <h5 class="card-title">✍️ Günlük Yazılar</h5>
                <p class="card-text">Her gün İngilizce pratik yaparak yazma becerini geliştir.</p>
              </div>
            </div>
          </a>
        <?php else: ?>
          <div class="card h-100 shadow-sm border-warning">
            <div class="card-body text-center">
              <h5 class="card-title">✍️ Günlük Yazılar</h5>
              <p class="card-text text-muted">Bu özelliği kullanmak için giriş yapmalısınız.</p>
              <a href="login.php" class="btn btn-light btn-lg btn-sm">Giriş Yap</a>
            </div>
          </div>
        <?php endif; ?>
      </div>

      <!-- Giriş gerekli kart -->
      <div class="col-md-4">
        <?php if (isset($_SESSION['user_id'])): ?>
          <a href="quizs.php" class="text-decoration-none text-dark">
            <div class="card h-100 shadow-sm">
              <div class="card-body text-center">
                <h5 class="card-title">🧠 Mini Quizler</h5>
                <p class="card-text">Seviye bazlı testlerle bilginizi ölçün ve gelişiminizi takip edin.</p>
              </div>
            </div>
          </a>
        <?php else: ?>
          <div class="card h-100 shadow-sm border-warning">
            <div class="card-body text-center">
              <h5 class="card-title">🧠 Mini Quizler</h5>
              <p class="card-text text-muted">Bu özelliği kullanmak için giriş yapmalısınız.</p>
              <a href="login.php" class="btn btn-light btn-lg btn-sm">Giriş Yap</a>
            </div>
          </div>
        <?php endif; ?>
      </div>

    </div>
  </div>
</section>

</main>

<?php include('include/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
