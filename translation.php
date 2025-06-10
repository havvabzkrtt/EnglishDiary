<!DOCTYPE html>
<html lang="tr">
<?php 
$pageTitle = "Ana Sayfa"; 
include('include/head.php'); 
?>
<head>
  <link rel="stylesheet" href="assets/styles.css"> <!-- Sticky footer için -->
</head>
<body>

<?php include('include/navbar.php'); ?> 

<main>
  <h1>Metin Çeviri</h1>

  <form method="post" action="">
    <label for="text">Çevirmek istediğiniz metni girin:</label><br>
    <input type="text" id="text" name="text" style="width:300px;" required
      value="<?php echo isset($_POST['text']) ? htmlspecialchars($_POST['text']) : ''; ?>">
    <button type="submit">Çevir</button>
  </form>

    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['text'])) {
    $text = $_POST['text'];

    $url = "https://libretranslate.com/translate";

    $data = [
        'q' => $text,
        'source' => 'tr',
        'target' => 'en',
        'format' => 'text'
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded',
        'Accept: application/json',
        'User-Agent: Mozilla/5.0'
    ]);

    $result = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    if ($err) {
        echo "<p>Çeviri sırasında hata oluştu: $err</p>";
    } else {
        echo "<h3>API'den Gelen Ham Cevap:</h3>";
        echo "<pre>" . htmlspecialchars($result) . "</pre>";

        $response = json_decode($result, true);
        if (isset($response['translatedText'])) {
            echo "<h2>Çeviri sonucu:</h2>";
            echo "<p><strong>Orijinal:</strong> " . htmlspecialchars($text) . "</p>";
            echo "<p><strong>İngilizce:</strong> " . htmlspecialchars($response['translatedText']) . "</p>";
        } else {
            echo "<p>Beklenmeyen cevap alındı.</p>";
        }
    }
}
?>


</main>

<?php include('include/footer.php'); ?>

</body>
</html>
