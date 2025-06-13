<!DOCTYPE html>
<html lang="tr">
<?php 
$pageTitle = "Ana Sayfa"; 
include('../include/head.php'); 
?>
<head>
  <link rel="stylesheet" href="../assets/styles.css">
  <style>
    body {
        background-color: #ECF0F1;
        font-family: 'Segoe UI', sans-serif;
    }

    main {
        padding: 30px;
        max-width: 600px;
        margin: 50px auto;
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-top: 5px solid #2C3E50;
    }

    h2 {
        color: #2C3E50;
        text-align: center;
        margin-bottom: 25px;
    }

    label {
        font-weight: bold;
        color: #2C3E50;
    }

    input[type="text"], select {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        margin-bottom: 20px;
        border-radius: 6px;
        border: 1px solid #ccc;
    }

    input[type="submit"] {
        background-color: #3498DB;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
        background-color: #2C3E50;
    }

    .result-box {
        margin-top: 20px;
        background-color: #F4F6F6;
        border-left: 5px solid #2C3E50;
        padding: 15px;
        border-radius: 6px;
        font-style: italic;
    }

    .error {
        color: red;
        font-weight: bold;
        text-align: center;
        margin-top: 15px;
    }
  </style>
</head>
<body>

<?php include('../include/navbar.php'); ?> 

<main>
    <h2>Çeviri Aracı</h2>
    <form method="post">
        <label for="text">Metin:</label>
        <input type="text" id="text" name="text" required>

        <label for="direction">Yön:</label>
        <select name="direction" id="direction">
            <option value="en-tr">İngilizce → Türkçe</option>
            <option value="tr-en">Türkçe → İngilizce</option>
        </select>

        <input type="submit" value="Çevir">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $text = $_POST['text'];
        $direction = $_POST['direction'];

        if ($direction === "en-tr") {
            $from = "en";
            $to = "tr";
        } else {
            $from = "tr";
            $to = "en";
        }

        $data = [
            'text' => $text,
            'from' => $from,
            'to' => $to
        ];

        $options = [
            'http' => [
                'header'  => "Content-type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data)
            ]
        ];

        $context  = stream_context_create($options);
        $result = file_get_contents('http://127.0.0.1:5000/translate', false, $context);

        if ($result === FALSE) {
            echo "<div class='error'>API isteği başarısız!</div>";
        } else {
            $response = json_decode($result, true);
            echo "<div class='result-box'><strong>Çeviri:</strong><br>" . htmlspecialchars($response['translated_text']) . "</div>";
        }
    }
    ?>
</main>

<?php include('../include/footer.php'); ?>

</body>
</html>
