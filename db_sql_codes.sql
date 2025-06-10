-- user tablosu

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


------------------------------------------------------------
--- flashcards.php için 
CREATE TABLE flashcards_words (
  id INT AUTO_INCREMENT PRIMARY KEY,
  word_en VARCHAR(255) NOT NULL,
  meaning_tr VARCHAR(255) NOT NULL,
  example_en TEXT,
  level VARCHAR(2) NOT NULL DEFAULT 'A0' -- A0, A1, B1 gibi
);


-- flashcards_words tablosu — kelime verileri ve seviyeleri
-- alan adı	tip	açıklama
-- id	INT PK AI	Birincil anahtar
-- word_en	VARCHAR(255)	İngilizce kelime
-- meaning_tr	VARCHAR(255)	Türkçe anlamı
-- example_en	TEXT	İngilizce örnek cümle
-- level	TINYINT	Kelimenin seviyesi (1-5 gibi)


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


-- Kullanıcının bilmediği kelimeler 
CREATE TABLE user_unknown_words (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  word_id INT NOT NULL,
  added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (word_id) REFERENCES flashcards_words(id)
);

-- user_unknown_words tablosu — kullanıcıların bilmediği kelimeler
-- alan adı	tip	açıklama
-- id	INT PK AI	Birincil anahtar
-- user_id	INT	users tablosundan kullanıcı ID'si
-- word_id	INT	flashcards_words tablosundaki kelime ID'si
-- added_at	TIMESTAMP	Kayıt zamanı (default CURRENT_TIMESTAMP)


-- Kullanıcının bildiği kelimeler

CREATE TABLE user_known_words (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  word_id INT NOT NULL,
  added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (word_id) REFERENCES flashcards_words(id)
);


----------------------------------------------

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

----------------------------------------------

-- 3. Reading Texts 
CREATE TABLE reading_texts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    level ENUM('A1', 'A2', 'B1', 'B2', 'C1', 'C2') NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- title: Parçanın başlığı.
-- content: Asıl metin içeriği.
-- level: Dil seviyesi (CEFR seviyeleri).
-- created_at: Oluşturulma tarihi.


INSERT INTO reading_texts (title, content, level) VALUES
-- A1 SEVİYE
('My Daily Routine', 
'I wake up at 7 a.m. every day. I brush my teeth and wash my face. Then I eat breakfast with my family. After that, I go to school by bus. In the evening, I do my homework and go to bed at 9 p.m.', 
'A1'),
('My Family', 
'I live with my parents and my brother. My mother is a teacher and my father is a doctor. We have a small house near the park. On Sundays, we go to the zoo or play games together. I love my family very much.', 
'A1'),

-- A2 SEVİYE
('Going to the Market', 
'Every Saturday, I go to the market with my mother. We buy fresh vegetables, fruits, and eggs. The market is always crowded and colorful. I help my mother carry the bags. Sometimes she buys me ice cream too.', 
'A2'),
('My Favorite Hobby', 
'I like painting in my free time. I have many brushes and colors at home. I paint pictures of animals and nature. Sometimes I give my paintings to my friends. Painting makes me happy and relaxed.', 
'A2'),

-- B1 SEVİYE
('My First Day at Work', 
'I remember my first day at work clearly. I was nervous but also very excited. My coworkers were friendly and helped me understand everything. I learned how to use the computer system and answer customer questions. At the end of the day, I felt proud of myself.', 
'B1'),
('A Rainy Day', 
'Yesterday, it rained all day long. I stayed at home and read a good book. The sound of the rain was calming. I also made some hot chocolate and called my friend. Even though I didn’t go outside, it was a nice day.', 
'B1'),

-- B2 SEVİYE
('City Life vs Country Life', 
'Living in the city can be exciting and full of opportunities. There are many shops, restaurants, and things to do. However, it can also be noisy and stressful. Country life is more peaceful and quiet, but sometimes boring. People must choose what suits them best.', 
'B2'),
('Learning a New Language', 
'Learning a new language is both challenging and rewarding. It helps you communicate with more people and understand different cultures. You need to practice every day and not be afraid to make mistakes. Watching movies or reading books in that language helps a lot. It takes time, but it’s worth it.', 
'B2'),

-- C1 SEVİYE
('The Impact of Technology', 
'Technology has changed the way we live and work. We can now connect with people around the world instantly. While it offers many advantages, it also brings challenges like reduced privacy. The key is to use technology responsibly. Understanding its effects is important for our future.', 
'C1'),
('Traveling Abroad', 
'Traveling to other countries gives you a new perspective on life. You learn about different cultures, languages, and traditions. It can sometimes be uncomfortable, but also very exciting. You grow as a person and become more open-minded. Every trip teaches you something new.', 
'C1'),

-- C2 SEVİYE
('The Philosophy of Happiness', 
'Happiness is a complex concept that has been discussed for centuries. Some believe it comes from personal achievements, while others see it as a state of mind. Philosophers like Aristotle argued that true happiness comes from living a virtuous life. In modern times, people link happiness with well-being and balance. It remains one of the most profound questions in human life.', 
'C2'),
('Economic Globalization', 
'Economic globalization refers to the increasing integration of economies worldwide. It allows goods, services, and capital to flow more freely across borders. While it boosts economic growth, it also creates inequality and job displacement in some regions. Policymakers must balance the benefits and drawbacks. The debate around globalization is likely to continue for decades.', 
'C2');
