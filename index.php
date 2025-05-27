<?php session_start(); ?>
<!DOCTYPE html>
<html lang="tr">
<?php $pageTitle = "Ana Sayfa"; include('include/head.php'); ?>
<body>

<?php include('include/navbar.php'); ?>

<!-- Hero Alanı -->
<section class="py-5 text-center bg-primary text-white">
  <div class="container">
    <h1 class="display-5 fw-bold">Learn English the Smart Way!</h1>
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
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body text-center">
            <h5 class="card-title">📘 Kelime Kartları</h5>
            <p class="card-text">Kendi kelime defterini oluştur ve tekrar et.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body text-center">
            <h5 class="card-title">✍️ Günlük Yazılar</h5>
            <p class="card-text">Her gün İngilizce pratik yaparak yazma becerini geliştir.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body text-center">
            <h5 class="card-title">🧠 Mini Quizler</h5>
            <p class="card-text">Seviye bazlı testlerle bilginizi ölçün ve gelişiminizi takip edin.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include('include/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
