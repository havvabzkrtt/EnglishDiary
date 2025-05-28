let currentIndex = 0;

const flashcard = document.getElementById('flashcard');
const knowBtn = document.getElementById('know-btn');
const dontKnowBtn = document.getElementById('dont-know-btn');

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
}

function nextCard() {
    currentIndex++;
    if (currentIndex >= words.length) {
        alert('Tüm kelimeler tamamlandı!');
        currentIndex = 0;
    }
    updateCard();
}


// İlk kelimeyi yükle
updateCard();

// Flashcard tıklayınca da çevirme opsiyonu (isteğe bağlı)
flashcard.addEventListener('click', () => {
    if (flashcard.classList.contains('flipped')) {
        showFront();
    } else {
        showBack();
    }
});





const finishMessage = document.getElementById('finish-message');
const newWordBtn = document.getElementById('new-word-btn');

function nextCard() {
    currentIndex++;
    if (currentIndex >= words.length) {
        finishMessage.textContent = '🎉 Tüm kelimeler tamamlandı!';
        knowBtn.disabled = true;
        dontKnowBtn.disabled = true;
        newWordBtn.disabled = true;
        return;
    }
    finishMessage.textContent = '';
    knowBtn.disabled = false;
    dontKnowBtn.disabled = false;
    newWordBtn.disabled = false;
    updateCard();
}

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
        setTimeout(() => {
            
        }, 2500);
    })
    .catch(error => {
        console.error('Hata:', error);
        setTimeout(() => {
            
        }, 2500);
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
    setTimeout(() => {
        
    }, 2500);
})
.catch(error => {
    console.error('Hata:', error);
    setTimeout(() => {
        
    }, 2500);
});
});


// Yeni Kelime butonu: anında sonraki kelimeye geç
newWordBtn.addEventListener('click', () => {
    nextCard();
});

// İlk kelimeyi yükle ve butonları aktif yap
updateCard();
finishMessage.textContent = '';
knowBtn.disabled = false;
dontKnowBtn.disabled = false;
newWordBtn.disabled = false;

