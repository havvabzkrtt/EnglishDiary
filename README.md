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



