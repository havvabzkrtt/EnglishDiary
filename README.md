# EnglishDiary


# Localhost'ta Belirli Klasörde Projeyi Çalıştırmak

### Hedef:

Projeyi her zaman `htdocs` içinde değil, örneğin şu klasörde çalıştırmak istiyoruz:

```
C:\Users\havva\OneDrive\Desktop\porfolio-site
```

---

### 1. Apache Virtual Hosts Ayarı (`httpd-vhosts.conf`)

Kodun bulunduğu yol belirlenmeli: 
```
C:\Users\havva\Desktop\EnglishDiary
```

Apache Virtual Hosts Ayarı için iligili dosya açılır:

```
C:\xampp\apache\conf\extra\httpd-vhosts.conf
```

En altına şu yapı eklenir:

```apache
<VirtualHost *:80>
    ServerName EnglishDiary.local
    DocumentRoot "C:\Users\havva\Desktop\EnglishDiary"

    <Directory "C:\Users\havva\Desktop\EnglishDiary">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Dosyada bulunan diğer ksımlar yorum satırına alınmalı.
---

### 2. Hosts Dosyasına Domain Ekle

Hosts dosyasını yönetici olarak aç:

```
C:\Windows\System32\drivers\etc\hosts
```

En altına şunu ekle:

```
127.0.0.1    EnglishDiary.local

```

> ⚠️ Not: Dosya sadece **Yönetici olarak açılmış Not Defteri** ile düzenlenebilir.

---

### 3. Apache’yi ve MySQL'i Yeniden Başlat

1. XAMPP Kontrol Panelini aç.
2. Apache'yi durdur → yeniden başlat.
3. MySQL'i durdur → yeniden başlat. 

---

### 4. Tarayıcıdan Test Et

Adres çubuğuna yaz:

```
http://EnglishDiary.local
```

`index.php` sayfası yükleniyorsa ayarlar başarılıdır ✅



# SQL Tabloları 


### flashcards.php için 

```bash
CREATE TABLE flashcards_words (
  id INT AUTO_INCREMENT PRIMARY KEY,
  word_en VARCHAR(255) NOT NULL,
  meaning_tr VARCHAR(255) NOT NULL,
  example_en TEXT,
  level VARCHAR(2) NOT NULL DEFAULT 'A0' -- A0, A1, B1 gibi
);
```

```
flashcards_words tablosu — kelime verileri ve seviyeleri
alan adı	tip	açıklama
id	INT PK AI	Birincil anahtar
word_en	VARCHAR(255)	İngilizce kelime
meaning_tr	VARCHAR(255)	Türkçe anlamı
example_en	TEXT	İngilizce örnek cümle
level	TINYINT	Kelimenin seviyesi (1-5 gibi)
```

```bash
INSERT INTO flashcards_words (word_en, meaning_tr, example_en, level) VALUES
('apple', 'elma', 'I eat an apple every day.', 'A0'),
('book', 'kitap', 'She is reading a new book.', 'A0'),
('happy', 'mutlu', 'He feels happy today.', 'A1'),
('run', 'koşmak', 'They run in the park every morning.', 'A1'),
('improve', 'geliştirmek', 'You need to improve your English skills.', 'B1'),
('challenge', 'meydan okuma', 'Learning a new language is a challenge.', 'B1'),
('development', 'gelişim', 'The development of technology is fast.', 'B2'),
('environment', 'çevre', 'We must protect the environment.', 'B2'),
('sophisticated', 'karmaşık, gelişmiş', 'This is a sophisticated computer system.', 'C1'),
('nevertheless', 'yine de, buna rağmen', 'It was raining; nevertheless, we went out.', 'C1');

```


```bash


CREATE TABLE user_unknown_words (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  word_id INT NOT NULL,
  added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (word_id) REFERENCES flashcards_words(id)
);
```


```
user_unknown_words tablosu — kullanıcıların bilmediği kelimeler
alan adı	tip	açıklama
id	INT PK AI	Birincil anahtar
user_id	INT	users tablosundan kullanıcı ID'si
word_id	INT	flashcards_words tablosundaki kelime ID'si
added_at	TIMESTAMP	Kayıt zamanı (default CURRENT_TIMESTAMP)
```

```bash

CREATE TABLE user_known_words (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  word_id INT NOT NULL,
  added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (word_id) REFERENCES flashcards_words(id)
);
```

----------------------------------------------
```bash

-- 1. Grammar Quiz Soruları
CREATE TABLE grammar_quiz_questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question_text TEXT NOT NULL,
    option_a VARCHAR(255) NOT NULL,
    option_b VARCHAR(255) NOT NULL,
    option_c VARCHAR(255) NOT NULL,
    option_d VARCHAR(255) NOT NULL,
    correct_option ENUM('A', 'B', 'C', 'D') NOT NULL,
    level ENUM('A1', 'A2', 'B1', 'B2', 'C1', 'C2') NOT NULL,
    topic VARCHAR(100) NOT NULL
);

```bash

INSERT INTO grammar_quiz_questions (question_text, option_a, option_b, option_c, option_d, correct_option, level, topic) VALUES
-- A1 - Present Simple
('She ____ to school every day.', 'go', 'goes', 'going', 'gone', 'B', 'A1', 'Present Simple'),

-- A1 - To be
('I ____ a student.', 'is', 'are', 'am', 'be', 'C', 'A1', 'To be'),

-- A2 - Past Simple
('They ____ to the park yesterday.', 'go', 'goes', 'went', 'going', 'C', 'A2', 'Past Simple'),

-- A2 - Countable/Uncountable
('How ____ sugar do you need?', 'many', 'much', 'some', 'any', 'B', 'A2', 'Countable and Uncountable Nouns'),

-- B1 - Present Perfect
('I ____ finished my homework.', 'have', 'has', 'had', 'having', 'A', 'B1', 'Present Perfect'),

-- B1 - First Conditional
('If it rains, we ____ at home.', 'stay', 'will stay', 'stayed', 'staying', 'B', 'B1', 'First Conditional'),

-- B2 - Passive Voice
('The cake ____ by my sister.', 'was made', 'made', 'has made', 'makes', 'A', 'B2', 'Passive Voice'),

-- B2 - Reported Speech
('He said that he ____ late.', 'is', 'was', 'will be', 'has been', 'B', 'B2', 'Reported Speech'),

-- C1 - Inversion
('Rarely ____ such a beautiful view.', 'I saw', 'have I seen', 'did I see', 'I had seen', 'B', 'C1', 'Inversion'),

-- C2 - Mixed Conditionals
('If he had studied, he ____ a better job now.', 'would get', 'will have', 'would have', 'would have had', 'A', 'C2', 'Mixed Conditionals');
```

```bash
-- 2. Kullanıcının yanlış cevapladığı grammar konuları
CREATE TABLE user_wrong_grammar_topics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    topic VARCHAR(100) NOT NULL,
    question_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (question_id) REFERENCES grammar_quiz_questions(id)
);



```