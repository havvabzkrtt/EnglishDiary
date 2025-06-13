

# 🧠 Çeviri Uygulaması (TR ⇄ EN)

Bu proje, PHP arayüzü üzerinden Flask API ile İngilizce ⇄ Türkçe kelime çevirisi yapar.

## 📁 Klasör Yapısı

```

EnglishDiary/
├── translation/
│   ├── translation.php       # PHP arayüzü
│   ├── app.py                # Flask API
│   ├── model\_en\_tr/          # EN → TR modeli
│   └── model\_tr\_en/          # TR → EN modeli
├── include/
├── assets/

```

## ⚙️ Gereksinimler

### Python
```bash
pip install flask transformers torch
````

### PHP

* PHP 8+
* `allow_url_fopen` açık

## 🚀 Kullanım

1. Modelleri HuggingFace’den indir:

   * `Helsinki-NLP/opus-mt-en-tr` → `model_en_tr/`
   * `Helsinki-NLP/opus-mt-tr-en` → `model_tr_en/`

2. Flask API’yi çalıştır:

```bash
cd translation
python app.py
```

3. Tarayıcıda aç:

```
http://localhost/EnglishDiary/translation/translation.php
```

## 📡 API

* **URL:** `POST /translate`
* **İstek:**

```json
{ "text": "Merhaba", "from": "tr", "to": "en" }
```

* **Yanıt:**

```json
{ "translated_text": "Hello" }
```

## 🎨 Arayüz

* Ana renk: `#2C3E50`
* Responsive ve kutu içinde basit bir tasarım

---

Geliştirme ve kullanım için uygundur.

