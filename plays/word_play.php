<?php 
session_start(); 
$rootPath = dirname(__DIR__);
include($rootPath . '/include/head.php'); 

// Veritabanı bağlantısı (mysqli kullanılıyor)
include('../config/db.php');

// Soru verilerini çekiyoruz
$result = $conn->query("SELECT id, word, answer1, answer2, answer3, answer4, correct_answer FROM dogru_ceviriyi_bul");
$questions = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <link rel="stylesheet" href="../assets/styles.css">
  <title>Kelime Oyunu</title>
</head>
<body>

<?php include($rootPath . '/include/navbar.php'); ?>

<main class="container py-5">
  <h1 class="text-center mb-4">🎮 Kelime Oyunu</h1>

  <!-- Skor göstergesi -->
  <div class="text-end mb-3">
    <strong>Skor: </strong><span id="score">0</span>
  </div>

  <!-- 🧠 Oyun 1: Doğru Çeviriyi Bul -->
  <section class="mb-5">
    <h3 class="mb-3">🧠 Doğru Çeviriyi Bul</h3>
    <div class="card shadow-sm">
      <div class="card-body">
        <p><strong>Kelime:</strong> <span id="quiz-word">Yükleniyor...</span></p>
        <div id="quiz-options" class="mb-3"></div>
        <div id="quiz-result" class="mt-3"></div>
      </div>
    </div>
  </section>


  
  <!-- 🎲 Diğer Oyunlar -->
<?php
    // session zaten start edilmiş

    // Kullanıcı giriş yapmış mı kontrolü
    $loggedIn = isset($_SESSION['user_id']); // ya da senin oturum değişkenin neyse

    // Oyunlar dizisi (her oyun için başlık, açıklama, link)
    $games = [
        [
            'title' => '🅰️ Eksik Harfi Doldur',
            'desc' => 'Kelimenin eksik harfini tahmin ederek tamamla.',
            'link' => 'plays/missing_letter.php'
        ],
        [
            'title' => '🔗 Kelime Eşleştirme',
            'desc' => 'İngilizce kelimeyle Türkçesini doğru eşleştir.',
            'link' => 'plays/word_match.php'
        ],
        [
            'title' => '⌨️ Yazım Oyunu',
            'desc' => 'Duyduğun ya da gördüğün kelimeyi doğru yaz.',
            'link' => 'plays/spelling_game.php'
        ],
    ];
    ?>

  <section class="mt-5">
  <h4 class="mb-4">🎲 Diğer Oyunlar</h4>
  <div class="row g-4">

    <?php foreach ($games as $game): ?>
    <div class="col-md-4">
      <div class="card h-100 shadow-sm text-center p-3">
        <h5 class="card-title"><?= htmlspecialchars($game['title']) ?></h5>
        <p class="card-text"><?= htmlspecialchars($game['desc']) ?></p>
        <?php if ($loggedIn): ?>
            <a href="<?= htmlspecialchars($game['link']) ?>" class="btn btn-outline-secondary mt-auto">Oyna</a>
        <?php else: ?>
            <a href="../login.php" class="btn btn-outline-secondary mt-auto">Giriş Yap</a>
        <?php endif; ?>
      </div>
    </div>
    <?php endforeach; ?>

  </div>
</section>


</main>

<?php include($rootPath . '/include/footer.php'); ?>

<script>
  const questions = <?php echo json_encode($questions); ?>;

  let score = 0;
  let currentQuestionIndex = null;
  let previousCorrect = null;
  let previousCorrectAnswer = null;

  const quizWord = document.getElementById("quiz-word");
  const quizOptionsDiv = document.getElementById("quiz-options");
  const quizResult = document.getElementById("quiz-result");
  const scoreSpan = document.getElementById("score");

  function shuffle(array) {
    for(let i = array.length - 1; i > 0; i--) {
      const j = Math.floor(Math.random() * (i + 1));
      [array[i], array[j]] = [array[j], array[i]];
    }
    return array;
  }

  function getNextQuestion() {
    if(questions.length === 0) {
      quizWord.textContent = "Veritabanında hiç soru yok.";
      quizOptionsDiv.innerHTML = "";
      return null;
    }

    let nextIndex;
    do {
      nextIndex = Math.floor(Math.random() * questions.length);
    } while(nextIndex === currentQuestionIndex && questions.length > 1);

    currentQuestionIndex = nextIndex;
    return questions[nextIndex];
  }

  function displayQuestion(question) {
    quizWord.textContent = question.word;

    const options = shuffle([
      question.answer1,
      question.answer2,
      question.answer3,
      question.answer4
    ]);

    quizOptionsDiv.innerHTML = "";

    options.forEach(option => {
      const btn = document.createElement("button");
      btn.type = "button";
      btn.className = "btn-custom";  // kendi css class
      btn.textContent = option;
      btn.addEventListener("click", () => {
        // Tıklama sonrası diğer butonları devre dışı bırak
        Array.from(quizOptionsDiv.children).forEach(b => b.disabled = true);
        handleAnswer(option, question.correct_answer);
      });
      quizOptionsDiv.appendChild(btn);
    });
  }

  function handleAnswer(selected, correct) {
    let message = "";

    

    if(selected === correct) {
      score++;
      message += `<div class='text-success fw-bold'>✅ Doğru! Skor: ${score}</div>`;
      previousCorrect = true;
    } else {
      score = 0;
      message += `<div class='text-danger fw-bold'>❌ Yanlış. Doğru cevap: <strong>${correct}</strong>. Skor sıfırlandı.</div>`;
      previousCorrect = false;
    }

    previousCorrectAnswer = correct;
    scoreSpan.textContent = score;
    quizResult.innerHTML = message;

    setTimeout(() => {
      quizResult.innerHTML = "";
      const nextQuestion = getNextQuestion();
      if(nextQuestion) displayQuestion(nextQuestion);
      else {
        quizWord.textContent = "Tüm sorular kullanıldı!";
        quizOptionsDiv.innerHTML = "";
      }
    }, 2000); // Mesaj 3 saniye kalacak
  }

  // İlk soruyu göster
  const firstQuestion = getNextQuestion();
  if(firstQuestion) displayQuestion(firstQuestion);
  else quizWord.textContent = "Veritabanında hiç soru yok.";
</script>

</body>
</html>
