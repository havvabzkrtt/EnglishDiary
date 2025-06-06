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


---

# EnglishDiary

**EnglishDiary**, İngilizce kelime öğrenimini, günlük yazma pratiğini ve seviye bazlı quizlerle dil gelişimini destekleyen bir web uygulamasıdır. Kullanıcılar giriş yaparak kendi kelime defterlerini oluşturabilir, kelime kartlarıyla tekrar yapabilir, mini oyunlarla eğlenerek öğrenebilir ve gramer quizleriyle bilgilerini test edebilirler.

## Özellikler

- **Kullanıcı Kayıt & Giriş:** Güvenli kullanıcı yönetimi.
- **Kelime Kartları:** Seviye seçimine göre İngilizce kelimeleri kartlarla öğrenme ve bilinen/bilinmeyen olarak işaretleme.
- **Kelime Listesi:** Kullanıcının bildiği ve bilmediği kelimelerin ayrı listelenmesi.
- **Mini Quizler:** Gramer ve kelime bilgisini ölçen seviye bazlı testler.
- **Kelime Oyunları:** Eğlenceli oyunlarla kelime pekiştirme (doğru çeviriyi bul, eksik harfi doldur, eşleştirme vb.).
- **Profil ve Ayarlar:** Kullanıcı bilgileri, şifre güncelleme ve hesap silme.
- **Modern Arayüz:** Bootstrap tabanlı, mobil uyumlu ve kullanıcı dostu tasarım.

## Kurulum

1. **Projeyi Kopyalayın:**

```
git clone https://github.com/kullaniciadi/englishdiary.git
```


2. **Veritabanı Kurulumu:**
- `db_sql_codes.sql` dosyasındaki SQL komutlarını MySQL veritabanınıza uygulayın.

3. **Veritabanı Ayarları:**
- `config/db.php` dosyasında veritabanı bağlantı bilgilerinizi güncelleyin.

4. **Geliştirme Ortamı:**
- XAMPP/WAMP gibi bir local sunucu kullanıyorsanız, projenin kök dizinini `htdocs` veya uygun bir klasöre taşıyın.
- Gelişmiş kurulum için [README.md](README.md) dosyasındaki Virtual Host yönergelerini takip edebilirsiniz.

5. **Kullanım:**
- Tarayıcıda `http://localhost/EnglishDiary` veya belirlediğiniz domain ile uygulamayı başlatın.

## Klasör Yapısı

- `assets/` — CSS ve görseller
- `config/` — Veritabanı bağlantı dosyası
- `flashcards/` — Kelime kartları ve ilgili scriptler
- `include/` — Ortak başlık, navbar ve footer dosyaları
- `plays/` — Kelime oyunları
- Ana dizin: Giriş, kayıt, profil, quiz, ayarlar ve ana sayfa dosyaları

## Katkı

Katkıda bulunmak için lütfen bir fork oluşturun ve pull request gönderin.



---
**EnglishDiary** ile İngilizce öğrenimini daha eğlenceli ve verimli hale getirin!