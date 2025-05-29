let currentIndex = 0;

const flashcard = document.getElementById('flashcard');
const knowBtn = document.getElementById('know-btn');
const dontKnowBtn = document.getElementById('dont-know-btn');
const newWordBtn = document.getElementById('new-word-btn');
const finishMessage = document.getElementById('finish-message');

function showFront() {
    flashcard.classList.remove('flipped');
}

function showBack() {
    flashcard.classList.add('flipped');
}

function updateCard() {
    const word = words[currentIndex];
    flashcard.querySelector('.front h2').textContent = word.word_en;
    flashcard.querySelector('.back #meaning-tr').textContent = word.meaning_tr;
    flashcard.querySelector('.back #example-en').textContent = word.example_en;
    showFront();
    finishMessage.textContent = '';
    knowBtn.disabled = false;
    dontKnowBtn.disabled = false;
}

function nextCard() {
    currentIndex++;
    if (currentIndex >= words.length) {
        finishMessage.textContent = '🎉 Tüm kelimeler tamamlandı!';
        knowBtn.disabled = true;
        dontKnowBtn.disabled = true;
        newWordBtn.disabled = true;
        return;
    }
    updateCard();
}

// Flashcard tıklayınca çevirme opsiyonu
flashcard.addEventListener('click', () => {
    if (flashcard.classList.contains('flipped')) {
        showFront();
    } else {
        showBack();
    }
});

knowBtn.addEventListener('click', () => {
    showBack();

    const wordId = words[currentIndex].id;

    fetch('save_known_word.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ word_id: wordId }),
    })
    .then(response => response.json())
    .then(data => {
        console.log(data.message);
        knowBtn.disabled = true;
        dontKnowBtn.disabled = true;
    })
    .catch(error => {
        console.error('Hata:', error);
    });
});

dontKnowBtn.addEventListener('click', () => {
    showBack();

    const wordId = words[currentIndex].id;

    fetch('save_unknown_word.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ word_id: wordId }),
    })
    .then(response => response.json())
    .then(data => {
        console.log(data.message);
        knowBtn.disabled = true;
        dontKnowBtn.disabled = true;
    })
    .catch(error => {
        console.error('Hata:', error);
    });
});

newWordBtn.addEventListener('click', () => {
    nextCard();
});

// İlk kelimeyi yükle
updateCard();
